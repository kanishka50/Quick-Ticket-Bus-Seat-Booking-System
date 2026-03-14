<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverAssignment;
use App\Models\Schedule;
use App\Models\ScheduleDate;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAssignmentController extends Controller
{
    public function index()
    {
        $providerId = Auth::user()->provider->id;

        $assignments = DriverAssignment::whereHas('driver', function ($q) use ($providerId) {
            $q->where('provider_id', $providerId);
        })->with([
            'driver.user',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
        ])->orderBy('created_at', 'desc')
          ->paginate(15);

        return view('providers.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $providerId = Auth::user()->provider->id;

        $drivers = Driver::where('provider_id', $providerId)
            ->where('status', 'active')
            ->with('user')
            ->get();

        $schedules = Schedule::whereHas('bus', function ($q) use ($providerId) {
            $q->where('provider_id', $providerId);
        })->where('status', 'active')
          ->with(['route.origin', 'route.destination', 'bus'])
          ->get();

        return view('providers.assignments.create', compact('drivers', 'schedules'));
    }

    public function getScheduleDates(Schedule $schedule)
    {
        $providerId = Auth::user()->provider->id;

        if ($schedule->bus->provider_id != $providerId) {
            return response()->json([]);
        }

        $dates = ScheduleDate::where('schedule_id', $schedule->id)
            ->where('departure_date', '>=', now()->toDateString())
            ->where('status', 'scheduled')
            ->doesntHave('driverAssignment')
            ->orderBy('departure_date')
            ->get()
            ->map(function ($sd) {
                return [
                    'id' => $sd->id,
                    'date' => $sd->departure_date->format('d M Y'),
                    'available_seats' => $sd->available_seats,
                ];
            });

        return response()->json($dates);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'schedule_date_id' => 'required|exists:schedule_dates,id',
        ]);

        $providerId = Auth::user()->provider->id;

        $driver = Driver::findOrFail($validated['driver_id']);
        if ($driver->provider_id != $providerId) {
            return redirect()->back()->with('error', 'Invalid driver.');
        }

        $scheduleDate = ScheduleDate::findOrFail($validated['schedule_date_id']);
        $schedule = $scheduleDate->schedule;
        if ($schedule->bus->provider_id != $providerId) {
            return redirect()->back()->with('error', 'Invalid schedule date.');
        }

        if ($scheduleDate->driverAssignment) {
            return redirect()->back()->with('error', 'This schedule date already has a driver assigned.');
        }

        DriverAssignment::create($validated);

        // Notify the driver
        $schedule->load('route.origin', 'route.destination');
        $routeName = $schedule->route->origin->name . ' → ' . $schedule->route->destination->name;
        NotificationService::send(
            $driver->user_id,
            NotificationService::DRIVER_ASSIGNED,
            'New Trip Assigned',
            "You have been assigned to {$routeName} on {$scheduleDate->departure_date->format('d M Y')}.",
            $scheduleDate->id
        );

        return redirect()->route('provider.assignments.index')
            ->with('success', 'Driver assigned successfully.');
    }

    public function destroy(DriverAssignment $assignment)
    {
        $providerId = Auth::user()->provider->id;
        if ($assignment->driver->provider_id != $providerId) {
            return redirect()->route('provider.assignments.index')
                ->with('error', 'Unauthorized action.');
        }

        if ($assignment->status === 'active') {
            return redirect()->route('provider.assignments.index')
                ->with('error', 'Cannot remove assignment while trip is active.');
        }

        // Notify the driver before deleting
        $assignment->load('scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination');
        $routeName = $assignment->scheduleDate->schedule->route->origin->name . ' → ' . $assignment->scheduleDate->schedule->route->destination->name;
        NotificationService::send(
            $assignment->driver->user_id,
            NotificationService::DRIVER_UNASSIGNED,
            'Trip Assignment Removed',
            "Your assignment for {$routeName} on {$assignment->scheduleDate->departure_date->format('d M Y')} has been removed.",
            $assignment->schedule_date_id
        );

        $assignment->delete();

        return redirect()->route('provider.assignments.index')
            ->with('success', 'Assignment removed successfully.');
    }
}
