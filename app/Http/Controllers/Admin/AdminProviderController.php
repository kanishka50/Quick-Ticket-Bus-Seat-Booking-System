<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProviderController extends Controller
{
    /**
     * Display a listing of the providers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Provider::with('user');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $providers = $query->latest()->paginate(10);

        return view('admin.providers.index', compact('providers', 'status'));
    }

    /**
     * Show the form for creating a new provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.providers.create');
    }

    /**
     * Store a newly created provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'company_name' => 'required|string|max:255',
            'business_registration_number' => 'required|string|max:50|unique:providers',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'provider',
            ]);

            // Handle logo upload if provided
            $logoPath = null;
            if ($request->hasFile('company_logo')) {
                $logoPath = $request->file('company_logo')->store('logos', 'public');
            }

            // Create provider
            $provider = Provider::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_logo' => $logoPath,
                'business_registration_number' => $request->business_registration_number,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'description' => $request->description,
                'status' => 'active', // Admin-created providers are active by default
            ]);

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create provider: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified provider.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        $provider->load('user', 'buses');
        
        // Get some stats for this provider
        $busCount = $provider->buses->count();
        $activeRoutes = DB::table('schedules')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.provider_id', $provider->id)
            ->distinct('route_id')
            ->count('route_id');
            
        $totalBookings = DB::table('bookings')
            ->join('schedule_dates', 'bookings.schedule_date_id', '=', 'schedule_dates.id')
            ->join('schedules', 'schedule_dates.schedule_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.provider_id', $provider->id)
            ->count();
            
        $totalRevenue = DB::table('bookings')
            ->join('schedule_dates', 'bookings.schedule_date_id', '=', 'schedule_dates.id')
            ->join('schedules', 'schedule_dates.schedule_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.provider_id', $provider->id)
            ->where('bookings.payment_status', 'paid')
            ->sum('bookings.total_amount');
        
        return view('admin.providers.show', compact(
            'provider', 
            'busCount', 
            'activeRoutes', 
            'totalBookings', 
            'totalRevenue'
        ));
    }

    /**
     * Show the form for editing the specified provider.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        $provider->load('user');
        return view('admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $provider->user_id,
            'company_name' => 'required|string|max:255',
            'business_registration_number' => 'required|string|max:50|unique:providers,business_registration_number,' . $provider->id,
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $provider->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Handle password update if provided
            if ($request->filled('password')) {
                $provider->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Handle logo update if provided
            if ($request->hasFile('company_logo')) {
                // Delete old logo if exists
                if ($provider->company_logo) {
                    Storage::disk('public')->delete($provider->company_logo);
                }
                
                $logoPath = $request->file('company_logo')->store('logos', 'public');
                $provider->company_logo = $logoPath;
            }

            // Update provider
            $provider->update([
                'company_name' => $request->company_name,
                'business_registration_number' => $request->business_registration_number,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'description' => $request->description,
                'status' => $request->status,
                'reason' => $request->status !== $provider->status ? $request->reason : $provider->reason,
            ]);

            DB::commit();

            return redirect()->route('admin.providers.show', $provider->id)
                ->with('success', 'Provider updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update provider: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the provider status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Provider $provider)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending,suspended',
            'reason' => 'required_if:status,inactive,suspended',
        ]);

        $oldStatus = $provider->status;

        $provider->update([
            'status' => $request->status,
            'reason' => $request->reason,
        ]);

        // Notify provider about status change
        if ($oldStatus !== $request->status) {
            if ($request->status === 'active') {
                NotificationService::send(
                    $provider->user_id,
                    NotificationService::PROVIDER_APPROVED,
                    'Account Approved',
                    'Your provider account has been approved. You can now manage your buses and schedules.',
                    $provider->id
                );
            } elseif (in_array($request->status, ['inactive', 'suspended'])) {
                $reason = $request->reason ? " Reason: {$request->reason}" : '';
                NotificationService::send(
                    $provider->user_id,
                    NotificationService::PROVIDER_REJECTED,
                    'Account ' . ucfirst($request->status),
                    "Your provider account has been {$request->status}.{$reason}",
                    $provider->id
                );
            }
        }

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider status updated successfully.');
    }

    /**
     * Remove the specified provider from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        DB::beginTransaction();

        try {
            // Delete logo if exists
            if ($provider->company_logo) {
                Storage::disk('public')->delete($provider->company_logo);
            }

            // Get user ID before deleting provider
            $userId = $provider->user_id;

            // Delete provider
            $provider->delete();

            // Delete user
            User::find($userId)->delete();

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete provider: ' . $e->getMessage());
        }
    }
}