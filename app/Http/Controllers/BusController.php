<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusController extends Controller
{
    public function index()
    {
        $providerId = Auth::user()->provider->id;
        $buses = Bus::where('provider_id', $providerId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('providers.buses.index', compact('buses'));
    }

    public function create()
    {
        $busTypes = BusType::all();
        return view('providers.buses.create', compact('busTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_type_id' => 'required|exists:bus_types,id',
            'registration_number' => 'required|string|max:50|unique:buses',
            'name' => 'nullable|string|max:255',
            'seat_layout' => 'required|json',
            'amenities' => 'nullable|json',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        // Auto-calculate total_seats from seat_layout (count available seats only)
        $seatLayout = json_decode($validated['seat_layout'], true);
        $validated['total_seats'] = collect($seatLayout)->where('status', 'available')->count();
        $validated['provider_id'] = Auth::user()->provider->id;

        Bus::create($validated);

        return redirect()->route('provider.buses.index')
            ->with('success', 'Bus added successfully.');
    }

    public function edit(Bus $bus)
    {
        if ($bus->provider_id !== Auth::user()->provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $busTypes = BusType::all();
        return view('providers.buses.edit', compact('bus', 'busTypes'));
    }

    public function update(Request $request, Bus $bus)
    {
        if ($bus->provider_id !== Auth::user()->provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'bus_type_id' => 'required|exists:bus_types,id',
            'registration_number' => 'required|string|max:50|unique:buses,registration_number,' . $bus->id,
            'name' => 'nullable|string|max:255',
            'seat_layout' => 'required|json',
            'amenities' => 'nullable|json',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        // Auto-calculate total_seats from seat_layout (count available seats only)
        $seatLayout = json_decode($validated['seat_layout'], true);
        $validated['total_seats'] = collect($seatLayout)->where('status', 'available')->count();

        $bus->update($validated);

        return redirect()->route('provider.buses.index')
            ->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        if ($bus->provider_id !== Auth::user()->provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $bus->delete();

        return redirect()->route('provider.buses.index')
            ->with('success', 'Bus deleted successfully.');
    }
}
