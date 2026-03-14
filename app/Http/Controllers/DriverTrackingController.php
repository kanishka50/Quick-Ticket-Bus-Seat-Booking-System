<?php

namespace App\Http\Controllers;

use App\Events\BusLocationUpdated;
use App\Models\BusLocation;
use App\Models\DriverAssignment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverTrackingController extends Controller
{
    public function dashboard()
    {
        $driver = Auth::user()->driver;

        $todayAssignments = DriverAssignment::where('driver_id', $driver->id)
            ->whereHas('scheduleDate', function ($q) {
                $q->where('departure_date', now()->toDateString());
            })
            ->with([
                'scheduleDate.schedule.route.origin',
                'scheduleDate.schedule.route.destination',
                'scheduleDate.schedule.bus',
            ])
            ->get();

        $activeAssignment = $todayAssignments->firstWhere('status', 'active');

        return view('driver.dashboard', compact('todayAssignments', 'activeAssignment'));
    }

    public function startTrip(DriverAssignment $assignment)
    {
        $driver = Auth::user()->driver;

        if ($assignment->driver_id != $driver->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($assignment->status !== 'assigned') {
            return redirect()->back()->with('error', 'This trip cannot be started.');
        }

        // Check no other active trip
        $hasActive = DriverAssignment::where('driver_id', $driver->id)
            ->where('status', 'active')
            ->exists();

        if ($hasActive) {
            return redirect()->back()->with('error', 'You already have an active trip. End it before starting a new one.');
        }

        $assignment->update(['status' => 'active']);

        return redirect()->route('driver.trip', $assignment)
            ->with('success', 'Trip started! Location sharing is now active.');
    }

    public function trip(DriverAssignment $assignment)
    {
        $driver = Auth::user()->driver;

        if ($assignment->driver_id != $driver->id) {
            return redirect()->route('driver.dashboard')->with('error', 'Unauthorized action.');
        }

        if ($assignment->status !== 'active') {
            return redirect()->route('driver.dashboard')->with('error', 'This trip is not active.');
        }

        $assignment->load([
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
        ]);

        return view('driver.trip', compact('assignment'));
    }

    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'assignment_id' => 'required|exists:driver_assignments,id',
        ]);

        $driver = Auth::user()->driver;
        $assignment = DriverAssignment::findOrFail($validated['assignment_id']);

        if ($assignment->driver_id != $driver->id || $assignment->status !== 'active') {
            return response()->json(['error' => 'Invalid assignment'], 403);
        }

        // Upsert — single row per driver
        BusLocation::updateOrCreate(
            ['driver_id' => $driver->id],
            [
                'schedule_date_id' => $assignment->schedule_date_id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'location_name' => $request->input('location_name'),
                'speed' => $validated['speed'],
                'recorded_at' => now(),
            ]
        );

        // Broadcast to customers
        broadcast(new BusLocationUpdated(
            scheduleDateId: $assignment->schedule_date_id,
            latitude: (float) $validated['latitude'],
            longitude: (float) $validated['longitude'],
            locationName: $request->input('location_name'),
            speed: $validated['speed'] ? (float) $validated['speed'] : null,
            recordedAt: now()->toISOString(),
        ));

        return response()->json(['status' => 'ok']);
    }

    public function endTrip(DriverAssignment $assignment)
    {
        $driver = Auth::user()->driver;

        if ($assignment->driver_id != $driver->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($assignment->status !== 'active') {
            return redirect()->back()->with('error', 'This trip is not active.');
        }

        $assignment->update(['status' => 'completed']);

        // Remove location record
        BusLocation::where('driver_id', $driver->id)->delete();

        return redirect()->route('driver.dashboard')
            ->with('success', 'Trip ended successfully.');
    }

    /**
     * Display all notifications for the driver.
     */
    public function allNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('driver.notifications', compact('notifications'));
    }

    /**
     * Mark a single notification as read.
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    // API for customer tracking page
    public function getLocation($scheduleDateId)
    {
        $location = BusLocation::where('schedule_date_id', $scheduleDateId)
            ->first();

        if (!$location) {
            return response()->json(['tracking' => false]);
        }

        return response()->json([
            'tracking' => true,
            'latitude' => (float) $location->latitude,
            'longitude' => (float) $location->longitude,
            'location_name' => $location->location_name,
            'speed' => $location->speed ? (float) $location->speed : null,
            'recorded_at' => $location->recorded_at->toISOString(),
        ]);
    }
}
