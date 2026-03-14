<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusLocation;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function track(Booking $booking)
    {
        if ($booking->user_id != Auth::id()) {
            return redirect()->route('bookings.index')->with('error', 'Unauthorized.');
        }

        if ($booking->booking_status === 'cancelled') {
            return redirect()->route('bookings.show', $booking)->with('error', 'This booking has been cancelled.');
        }

        $booking->load([
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
            'scheduleDate.driverAssignment.driver.user',
        ]);

        $location = BusLocation::where('schedule_date_id', $booking->schedule_date_id)->first();

        return view('tracking.show', compact('booking', 'location'));
    }
}
