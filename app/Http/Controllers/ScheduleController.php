<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\ScheduleDate;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $providerId = Auth::user()->provider->id;
        $schedules = Schedule::whereHas('bus', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })->with(['route.origin', 'route.destination', 'bus.busType'])->paginate(10);

        return view('providers.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $providerId = Auth::user()->provider->id;
        $buses = Bus::where('provider_id', $providerId)
                    ->where('status', 'active')
                    ->get();
        $routes = Route::where('status', 'active')->with(['origin', 'destination'])->get();

        return view('providers.schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_time' => 'required|date_format:H:i,H:i:s',
            'arrival_time' => 'required|date_format:H:i,H:i:s',
            'price' => 'required|numeric|min:0.01',
            'status' => 'required|in:active,inactive',
        ]);

        $providerId = Auth::user()->provider->id;
        $bus = Bus::findOrFail($request->bus_id);

        if ($bus->provider_id != $providerId) {
            return redirect()->back()->with('error', 'You can only create schedules for your own buses.');
        }

        Schedule::create($validated);

        return redirect()->route('provider.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $providerId = Auth::user()->provider->id;

        if ($schedule->bus->provider_id != $providerId) {
            return redirect()->route('provider.schedules.index')
                ->with('error', 'You can only edit schedules for your own buses.');
        }

        // Include current bus even if inactive, so provider can see what's assigned
        $buses = Bus::where('provider_id', $providerId)
                    ->where(function ($q) use ($schedule) {
                        $q->where('status', 'active')
                          ->orWhere('id', $schedule->bus_id);
                    })->get();
        $routes = Route::where('status', 'active')->with(['origin', 'destination'])->get();

        // Load future active bookings for this schedule
        $futureBookings = Booking::whereHas('scheduleDate', function ($q) use ($schedule) {
            $q->where('schedule_id', $schedule->id)
              ->where('departure_date', '>=', now()->toDateString());
        })->whereIn('booking_status', ['pending', 'confirmed'])
          ->with(['user', 'scheduleDate', 'seatBookings'])
          ->orderBy('created_at', 'desc')
          ->get();

        return view('providers.schedules.edit', compact('schedule', 'buses', 'routes', 'futureBookings'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_time' => 'required|date_format:H:i,H:i:s',
            'arrival_time' => 'required|date_format:H:i,H:i:s',
            'price' => 'required|numeric|min:0.01',
            'status' => 'required|in:active,inactive',
        ]);

        $providerId = Auth::user()->provider->id;
        $bus = Bus::findOrFail($request->bus_id);

        if ($bus->provider_id != $providerId) {
            return redirect()->back()->with('error', 'You can only update schedules for your own buses.');
        }

        $oldBusId = $schedule->bus_id;

        // If bus is changing, check for active bookings on future dates
        if ($oldBusId != $validated['bus_id']) {
            $hasActiveBookings = Booking::whereHas('scheduleDate', function ($q) use ($schedule) {
                $q->where('schedule_id', $schedule->id)
                  ->where('departure_date', '>=', now()->toDateString());
            })->whereIn('booking_status', ['pending', 'confirmed'])->exists();

            if ($hasActiveBookings) {
                return redirect()->back()->withInput()
                    ->with('error', 'Cannot change bus while there are active bookings on future dates. Please ask admin to cancel the affected bookings first.');
            }
        }

        $schedule->update($validated);

        // If bus changed, update available_seats on future schedule dates
        if ($oldBusId != $validated['bus_id']) {
            $seatLayout = json_decode($bus->seat_layout, true) ?? [];
            $newSeatCount = collect($seatLayout)->where('status', 'available')->count();

            ScheduleDate::where('schedule_id', $schedule->id)
                ->where('departure_date', '>=', now()->toDateString())
                ->where('status', 'scheduled')
                ->update(['available_seats' => $newSeatCount]);
        }

        return redirect()->route('provider.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $providerId = Auth::user()->provider->id;
        if ($schedule->bus->provider_id != $providerId) {
            return redirect()->route('provider.schedules.index')
                ->with('error', 'You can only delete schedules for your own buses.');
        }

        // Check for future schedule dates with active bookings
        $hasActiveBookings = Booking::whereHas('scheduleDate', function ($q) use ($schedule) {
            $q->where('schedule_id', $schedule->id)
              ->where('departure_date', '>=', now()->toDateString());
        })->whereIn('booking_status', ['pending', 'confirmed'])->exists();

        if ($hasActiveBookings) {
            return redirect()->route('provider.schedules.index')
                ->with('error', 'Cannot delete schedule with active bookings. Cancel the bookings first.');
        }

        $schedule->delete();

        return redirect()->route('provider.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    public function requestCancellation(Schedule $schedule)
    {
        $providerId = Auth::user()->provider->id;
        if ($schedule->bus->provider_id != $providerId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $schedule->load('route.origin', 'route.destination', 'bus');

        // Count active bookings on future dates
        $bookingCount = Booking::whereHas('scheduleDate', function ($q) use ($schedule) {
            $q->where('schedule_id', $schedule->id)
              ->where('departure_date', '>=', now()->toDateString());
        })->whereIn('booking_status', ['pending', 'confirmed'])->count();

        if ($bookingCount === 0) {
            return redirect()->back()->with('error', 'No active bookings to request cancellation for.');
        }

        $origin = $schedule->route->origin->name;
        $destination = $schedule->route->destination->name;
        $providerName = Auth::user()->provider->company_name ?? Auth::user()->name;

        // Notify all admin users
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin->id,
                NotificationService::CANCELLATION_REQUEST,
                'Booking Cancellation Request',
                "{$providerName} requests cancellation of {$bookingCount} booking(s) on schedule {$origin} → {$destination} (Bus: {$schedule->bus->registration_number}) for a bus change.",
                $schedule->id
            );
        }

        return redirect()->back()->with('success', "Cancellation request sent to admin for {$bookingCount} booking(s). Admin will review and cancel them.");
    }
}
