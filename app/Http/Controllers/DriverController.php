<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $providerId = Auth::user()->provider->id;
        $drivers = Driver::where('provider_id', $providerId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('providers.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('providers.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:255',
        ]);

        $providerId = Auth::user()->provider->id;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone'],
            'user_type' => 'driver',
        ]);
        $user->email_verified_at = now();
        $user->save();

        Driver::create([
            'user_id' => $user->id,
            'provider_id' => $providerId,
            'license_number' => $validated['license_number'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('provider.drivers.index')
            ->with('success', 'Driver added successfully.');
    }

    public function edit(Driver $driver)
    {
        $providerId = Auth::user()->provider->id;
        if ($driver->provider_id != $providerId) {
            return redirect()->route('provider.drivers.index')
                ->with('error', 'You can only edit your own drivers.');
        }

        $driver->load('user');
        return view('providers.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $providerId = Auth::user()->provider->id;
        if ($driver->provider_id != $providerId) {
            return redirect()->route('provider.drivers.index')
                ->with('error', 'You can only update your own drivers.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->user_id,
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $driver->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
        ]);

        if (!empty($validated['password'])) {
            $driver->user->update(['password' => Hash::make($validated['password'])]);
        }

        $driver->update([
            'license_number' => $validated['license_number'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('provider.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $providerId = Auth::user()->provider->id;
        if ($driver->provider_id != $providerId) {
            return redirect()->route('provider.drivers.index')
                ->with('error', 'You can only delete your own drivers.');
        }

        $hasActiveAssignments = $driver->assignments()
            ->where('status', 'active')
            ->exists();

        if ($hasActiveAssignments) {
            return redirect()->route('provider.drivers.index')
                ->with('error', 'Cannot delete driver with active trip assignments.');
        }

        $driver->user->delete();

        return redirect()->route('provider.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
}
