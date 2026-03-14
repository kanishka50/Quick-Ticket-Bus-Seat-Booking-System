<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Location;
use Illuminate\Http\Request;
class RouteController extends Controller
{
    /**
     * Display a listing of the routes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::with(['origin', 'destination'])->latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new route.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::where('status', 'active')->get();
        return view('admin.routes.create', compact('locations'));
    }

    /**
     * Store a newly created route in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin_id' => 'required|exists:locations,id',
            'destination_id' => 'required|exists:locations,id|different:origin_id',
            'distance' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Route::create([
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'distance' => $request->distance,
            'estimated_duration' => $request->estimated_duration,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully.');
    }

    /**
     * Display the specified route.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        $route->load(['origin', 'destination']);
        return view('admin.routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified route.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        $locations = Location::where('status', 'active')->get();
        return view('admin.routes.edit', compact('route', 'locations'));
    }

    /**
     * Update the specified route in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin_id' => 'required|exists:locations,id',
            'destination_id' => 'required|exists:locations,id|different:origin_id',
            'distance' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $route->update([
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'distance' => $request->distance,
            'estimated_duration' => $request->estimated_duration,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully.');
    }

}