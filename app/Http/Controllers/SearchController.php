<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Location;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Validate the request
        $request->validate([
            'origin' => 'required|exists:locations,id',
            'destination' => 'required|exists:locations,id',
            'date' => 'required|date|after_or_equal:today',
        ]);
    
        // Get the origin and destination locations
        $origin = Location::find($request->origin);
        $destination = Location::find($request->destination);
    
        // Find the route
        $route = Route::where('origin_id', $origin->id)
                      ->where('destination_id', $destination->id)
                      ->first();
    
        if (!$route) {
            return redirect()->back()->with('error', 'No routes found for the selected locations.');
        }
    
        // Get schedules for the route on the selected date
        $schedules = Schedule::where('route_id', $route->id)
        ->with(['bus' => function ($query) {
            $query->select('id', 'provider_id', 'name', 'registration_number', 'bus_type_id');
        }, 'bus.busType', 'bus.provider:id,company_name', 'scheduleDates' => function ($query) use ($request) {
            $query->where('departure_date', $request->date)
                ->where('status', 'scheduled');
        }])
        ->get()
        ->filter(function ($schedule) {
            return $schedule->scheduleDates->isNotEmpty();
        });
    
    
        // Check if schedules are empty
        $noSchedules = $schedules->isEmpty();
    
        return view('booking.schedules', compact('schedules', 'origin', 'destination', 'route', 'noSchedules'));
    }
}
