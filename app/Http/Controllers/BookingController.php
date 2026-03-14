<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\ScheduleDate;
use App\Models\SeatBooking;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Schedule $schedule, Request $request)
    {
        $date = $request->input('date', null);

        if (!$date) {
            return redirect()->back()->with('error', 'Please select a date.');
        }

        $scheduleDate = $schedule->scheduleDates()
            ->where('departure_date', $date)
            ->where('status', 'scheduled')
            ->first();

        if (!$scheduleDate) {
            return redirect()->back()->with('error', 'No scheduled journey found for this date.');
        }

        // Block booking if departure time has passed
        $departureDateTime = \Carbon\Carbon::parse($scheduleDate->departure_date->format('Y-m-d') . ' ' . $schedule->departure_time);
        if (now()->gt($departureDateTime)) {
            return redirect()->back()->with('error', 'This schedule has already departed. Booking is not allowed.');
        }

        $bookedSeats = SeatBooking::whereHas('booking', function($query) use ($scheduleDate) {
                $query->where('schedule_date_id', $scheduleDate->id)
                      ->whereIn('booking_status', ['confirmed', 'pending']);
            })
            ->pluck('seat_number')
            ->toArray();

        $seatLayout = json_decode($schedule->bus->seat_layout, true);

        return view('booking.seat-selection', compact('schedule', 'scheduleDate', 'seatLayout', 'bookedSeats', 'date'));
    }

    public function store(Schedule $schedule, Request $request)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'required|string',
            'date' => 'required|date',
        ]);

        $scheduleDate = $schedule->scheduleDates()
            ->where('departure_date', $request->date)
            ->where('status', 'scheduled')
            ->first();

        if (!$scheduleDate) {
            return redirect()->back()->with('error', 'No scheduled journey found for this date.');
        }

        // Block booking if departure time has passed
        $departureDateTime = \Carbon\Carbon::parse($scheduleDate->departure_date->format('Y-m-d') . ' ' . $schedule->departure_time);
        if (now()->gt($departureDateTime)) {
            return redirect()->back()->with('error', 'This schedule has already departed. Booking is not allowed.');
        }

        $bookedSeats = SeatBooking::whereHas('booking', function($query) use ($scheduleDate) {
                $query->where('schedule_date_id', $scheduleDate->id)
                      ->whereIn('booking_status', ['confirmed', 'pending']);
            })
            ->pluck('seat_number')
            ->toArray();

        $selectedSeats = $request->seats;
        $unavailableSeats = array_intersect($selectedSeats, $bookedSeats);

        if (count($unavailableSeats) > 0) {
            return redirect()->back()->with('error', 'Some of your selected seats are no longer available. Please choose different seats.');
        }

        $totalPassengers = count($request->seats);
        $totalAmount = $schedule->price * $totalPassengers;

        DB::beginTransaction();

        try {
            $booking = new Booking();
            $booking->booking_number = 'BK' . strtoupper(Str::random(8));
            $booking->user_id = Auth::id();
            $booking->schedule_date_id = $scheduleDate->id;
            $booking->total_passengers = $totalPassengers;
            $booking->total_amount = $totalAmount;
            $booking->payment_status = 'pending';
            $booking->booking_status = 'pending';
            $booking->save();

            foreach ($request->seats as $seatNumber) {
                $seatBooking = new SeatBooking();
                $seatBooking->booking_id = $booking->id;
                $seatBooking->seat_number = $seatNumber;
                $seatBooking->ticket_number = 'TK' . strtoupper(Str::random(8));
                $seatBooking->save();
            }

            $scheduleDate->available_seats -= $totalPassengers;
            $scheduleDate->save();

            DB::commit();

            // Notify customer: booking created
            $route = $schedule->route;
            $origin = $route->origin->name ?? '';
            $destination = $route->destination->name ?? '';
            NotificationService::send(
                Auth::id(),
                NotificationService::BOOKING_CREATED,
                'Booking Created',
                "Your booking #{$booking->booking_number} for {$origin} to {$destination} has been created. Please complete payment.",
                $booking->id
            );

            return redirect()->route('payment.show', $booking->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during booking. Please try again.');
        }
    }
}
