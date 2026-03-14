<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::latest()->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new location.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created location in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        Location::create($request->only([
            'name', 'district', 'province', 'latitude', 'longitude', 'status'
        ]));

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified location.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('admin.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified location.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified location in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $location->update($request->only([
            'name', 'district', 'province', 'latitude', 'longitude', 'status'
        ]));

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location updated successfully.');
    }

   
}