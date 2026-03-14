<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $scheduleId = $request->query('schedule');

        $query = Booking::with([
            'user',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
        ]);

        if ($status !== 'all') {
            $query->where('booking_status', $status);
        }

        // Filter by schedule (used when provider requests cancellation)
        if ($scheduleId) {
            $query->whereHas('scheduleDate', function ($q) use ($scheduleId) {
                $q->where('schedule_id', $scheduleId)
                  ->where('departure_date', '>=', now()->toDateString());
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['status' => $status, 'schedule' => $scheduleId]);

        $schedule = $scheduleId ? \App\Models\Schedule::with('route.origin', 'route.destination', 'bus')->find($scheduleId) : null;

        return view('admin.bookings.index', compact('bookings', 'status', 'schedule'));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'user',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
            'seatBookings',
            'payment',
        ]);

        return view('admin.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->booking_status === 'cancelled') {
            return redirect()->back()->with('error', 'This booking is already cancelled.');
        }

        // Cancel the booking
        $booking->booking_status = 'cancelled';
        $booking->save();

        // Restore available seats
        $scheduleDate = $booking->scheduleDate;
        $scheduleDate->available_seats += $booking->total_passengers;
        $scheduleDate->save();

        // Notify customer
        NotificationService::send(
            $booking->user_id,
            NotificationService::BOOKING_CANCELLED,
            'Booking Cancelled',
            "Your booking #{$booking->booking_number} has been cancelled by admin.",
            $booking->id
        );

        // Notify provider
        $booking->load('scheduleDate.schedule.bus.provider', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination');
        $providerUserId = $booking->scheduleDate->schedule->bus->provider->user_id ?? null;
        if ($providerUserId) {
            $origin = $booking->scheduleDate->schedule->route->origin->name ?? '';
            $destination = $booking->scheduleDate->schedule->route->destination->name ?? '';
            NotificationService::send(
                $providerUserId,
                NotificationService::BOOKING_CANCELLED_PROVIDER,
                'Booking Cancelled by Admin',
                "Booking #{$booking->booking_number} on {$origin} to {$destination} has been cancelled by admin.",
                $booking->id
            );
        }

        return redirect()->back()
            ->with('success', "Booking #{$booking->booking_number} has been cancelled successfully.");
    }
}
