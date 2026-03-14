<?php

// app/Http/Controllers/ScheduleDateController.php
namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleDateController extends Controller
{
    public function index()
    {
        $providerId = Auth::user()->provider->id;
        
        $schedules = Schedule::whereHas('bus', function($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })->with(['route.origin', 'route.destination', 'bus'])->get();
        
        return view('providers.schedules.dates', compact('schedules'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'dates' => 'required|array',
            'dates.*' => 'required|date|after_or_equal:today',
        ]);
        
        // Verify the schedule belongs to this provider
        $providerId = Auth::user()->provider->id;
        $schedule = Schedule::with('bus')->findOrFail($request->schedule_id);
        
        if ($schedule->bus->provider_id != $providerId) {
            return redirect()->back()->with('error', 'You can only manage your own schedules.');
        }
        
        // Count only available (non-disabled) seats from the layout
        $seatLayout = json_decode($schedule->bus->seat_layout, true) ?? [];
        $totalSeats = collect($seatLayout)->where('status', 'available')->count();
        $createdDates = 0;

        foreach ($request->dates as $date) {
            // Check if this date already exists for this schedule
            $exists = ScheduleDate::where('schedule_id', $request->schedule_id)
                                ->where('departure_date', $date)
                                ->exists();
            
            if (!$exists) {
                ScheduleDate::create([
                    'schedule_id' => $request->schedule_id,
                    'departure_date' => $date,
                    'available_seats' => $totalSeats,
                    'status' => 'scheduled'  // Updated to use 'scheduled'
                ]);
                $createdDates++;
            }
        }

        return redirect()->route('provider.schedules.dates')
            ->with('success', "{$createdDates} schedule dates created successfully.");
    }

    public function getScheduleDates($scheduleId)
    {
        // Fetch schedule dates for the given schedule ID
        $scheduleDates = ScheduleDate::where('schedule_id', $scheduleId)
            ->with('schedule.route.origin', 'schedule.route.destination', 'schedule.bus')
            ->get();

        if ($scheduleDates->isEmpty()) {
            return response()->json([]);
        }

        // Format the data as expected by the frontend
        $formattedDates = $scheduleDates->map(function ($date) {
            return [
                'id' => $date->id,
                'schedule_info' => $date->schedule->route->origin->name . ' → ' . $date->schedule->route->destination->name,
                'date' => $date->departure_date,
                'available_seats' => $date->available_seats,
                'total_seats' => $date->schedule->bus->total_seats,
                'status' => $date->status,
            ];
        });

        return response()->json($formattedDates);
    }


    // In ScheduleDateController.php
public function destroy(ScheduleDate $scheduleDate)
{
    // Verify the schedule date belongs to this provider
    $providerId = Auth::user()->provider->id;
    
    if ($scheduleDate->schedule->bus->provider_id != $providerId) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $scheduleDate->delete();
    
    return response()->json(['success' => 'Schedule date deleted successfully']);
}


public function updateStatus(Request $request, $dateId)
{
    $validated = $request->validate([
        'status' => 'required|in:scheduled,departed,completed,cancelled',
    ]);

    $scheduleDate = ScheduleDate::findOrFail($dateId);

    // Verify the schedule date belongs to the provider
    $providerId = Auth::user()->provider->id;
    if ($scheduleDate->schedule->bus->provider_id != $providerId) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $scheduleDate->status = $validated['status'];
    $scheduleDate->save();

    return response()->json(['success' => 'Status updated successfully']);
}


}