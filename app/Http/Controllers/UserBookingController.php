<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all bookings for the current user
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Check if the booking belongs to the current user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load relationships
        $booking->load([
            'scheduleDate',
            'scheduleDate.schedule',
            'scheduleDate.schedule.route',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
            'scheduleDate.schedule.bus.provider',
            'scheduleDate.driverAssignment',
            'scheduleDate.driverAssignment.driver',
            'scheduleDate.driverAssignment.driver.user',
            'seatBookings',
            'payment'
        ]);
        
        return view('user.booking-show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        // Check if the booking belongs to the current user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only allow cancellation for unpaid pending bookings
        if ($booking->booking_status !== 'pending' || $booking->payment_status === 'paid') {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }
        
        // Check if the departure date has passed
        $departureDateTime = $booking->scheduleDate->departure_date . ' ' . $booking->scheduleDate->schedule->departure_time;
        if (now() > $departureDateTime) {
            return redirect()->back()->with('error', 'Cannot cancel a booking after departure time.');
        }
        
        // Update booking status
        $booking->booking_status = 'cancelled';
        $booking->save();
        
        // Update available seats
        $scheduleDate = $booking->scheduleDate;
        $scheduleDate->available_seats += $booking->total_passengers;
        $scheduleDate->save();
        
        // Notify customer: booking cancelled
        NotificationService::send(
            Auth::id(),
            NotificationService::BOOKING_CANCELLED,
            'Booking Cancelled',
            "Your booking #{$booking->booking_number} has been cancelled.",
            $booking->id
        );

        // Notify provider: booking cancelled on their bus
        $booking->load('scheduleDate.schedule.bus.provider', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination');
        $providerUserId = $booking->scheduleDate->schedule->bus->provider->user_id ?? null;
        if ($providerUserId) {
            $origin = $booking->scheduleDate->schedule->route->origin->name ?? '';
            $destination = $booking->scheduleDate->schedule->route->destination->name ?? '';
            NotificationService::send(
                $providerUserId,
                NotificationService::BOOKING_CANCELLED_PROVIDER,
                'Booking Cancelled',
                "Booking #{$booking->booking_number} on {$origin} to {$destination} has been cancelled.",
                $booking->id
            );
        }

        return redirect()->route('user.bookings')->with('success', 'Your booking has been cancelled successfully.');
    }
}