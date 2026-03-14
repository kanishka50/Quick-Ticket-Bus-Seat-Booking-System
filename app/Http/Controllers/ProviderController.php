<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Booking;
use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProviderController extends Controller
{
    public function pending()
    {
        $provider = Provider::where('user_id', Auth::id())->first();

        if (!$provider) {
            return redirect()->route('provider.create');
        }

        if ($provider->status === 'active') {
            return redirect()->route('provider.dashboard');
        }

        return view('providers.pending', compact('provider'));
    }

    public function edit()
{
    $provider = Provider::where('user_id', Auth::id())->first();

    if (!$provider) {
        return redirect()->route('provider.create')->with('error', 'Please complete onboarding first.');
    }

    return view('providers.edit', compact('provider'));
}

public function update(Request $request)
{
    $provider = Provider::where('user_id', Auth::id())->first();

    if (!$provider) {
        return redirect()->route('home')->with('error', 'No provider profile found.');
    }

    // Validate input
    $validatedData = $request->validate([
        'company_name' => 'required|string|max:255',
        'business_registration_number' => 'required|string|max:50|unique:providers,business_registration_number,' . $provider->id,
        'contact_number' => 'required|string|max:20',
        'address' => 'required|string',
        'description' => 'nullable|string',
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Handle file upload if a new logo was provided
    if ($request->hasFile('company_logo')) {
        // Delete old logo if exists
        if ($provider->company_logo) {
            Storage::disk('public')->delete($provider->company_logo);
        }

        // Store new logo on public disk
        $logoPath = $request->file('company_logo')->store('logos', 'public');
        $validatedData['company_logo'] = $logoPath;
    }

    // Update provider record
    $provider->update($validatedData);

    return redirect()->route('provider.dashboard')->with('success', 'Profile updated successfully.');
}



    /**
 * Display the provider dashboard.
 *
 * @return \Illuminate\View\View
 */
public function dashboard()
{
    // Provider existence and active status already verified by 'provider' middleware
    $provider = Auth::user()->provider;

    // Fetch active buses count for the provider
    $activeBusesCount = $provider->buses()
        ->where('status', 'active') // Check bus status in the buses table
        ->count();

    // Fetch total buses count for the provider
    $totalBusesCount = $provider->buses()->count();

    // Fetch active schedules count for the provider
    $activeSchedulesCount = $provider->schedules()
        ->where('schedules.status', 'active') // Check schedule status in the schedules table
        ->count();

    // Fetch total bookings count for the provider's buses or schedules
    $totalBookingsCount = Booking::whereHas('scheduleDate.schedule.bus', function ($query) use ($provider) {
        $query->where('provider_id', $provider->id); // Ensure bookings are related to the provider's buses
    })->whereMonth('created_at', now()->month) // Filter bookings for the current month
      ->count();

    // Fetch recent bookings for the provider
    $recentBookings = Booking::whereHas('scheduleDate.schedule.bus', function ($query) use ($provider) {
        $query->where('provider_id', $provider->id); // Ensure bookings are related to the provider's buses
    })->with('scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination')
      ->orderBy('created_at', 'desc')
      ->take(10)
      ->get();

    // Get unread notifications for the provider
    $notifications = Notification::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('providers.dashboard', compact(
        'provider',
        'activeBusesCount',
        'totalBusesCount',
        'activeSchedulesCount',
        'totalBookingsCount',
        'recentBookings',
        'notifications'
    ));
}

    /**
     * Display all bookings for the provider's buses.
     */
    public function bookings(Request $request)
    {
        $provider = Auth::user()->provider;
        $status = $request->query('status', 'all');

        $query = Booking::whereHas('scheduleDate.schedule.bus', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })->with([
            'user',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
        ]);

        if ($status !== 'all') {
            $query->where('booking_status', $status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['status' => $status]);

        return view('providers.bookings.index', compact('bookings', 'status'));
    }

    /**
     * Display a specific booking's details for the provider.
     */
    public function bookingShow(Booking $booking)
    {
        $provider = Auth::user()->provider;

        // Load relationships
        $booking->load([
            'user',
            'scheduleDate.schedule.route.origin',
            'scheduleDate.schedule.route.destination',
            'scheduleDate.schedule.bus',
            'seatBookings',
            'payment',
        ]);

        // Verify booking belongs to this provider
        if ($booking->scheduleDate->schedule->bus->provider_id !== $provider->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('providers.bookings.show', compact('booking'));
    }

    /**
     * Display all notifications for the provider.
     */
    public function allNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('providers.notifications', compact('notifications'));
    }

    /**
     * Mark a single notification as read (provider).
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read (provider).
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }



    /**
     * Show the provider onboarding form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Verify the user is logged in and is of provider type
        if (!Auth::check() || Auth::user()->user_type !== 'provider') {
            return redirect()->route('login')->with('error', 'You must be logged in as a provider to access this page.');
        }
        
        // Check if the user already has a provider profile
        $existingProvider = Provider::where('user_id', Auth::id())->first();
        if ($existingProvider) {
            return redirect()->route('provider.dashboard')->with('info', 'You have already completed onboarding.');
        }
        
        return view('providers.create');
    }

    /**
     * Store a newly created provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'business_registration_number' => 'required|string|max:50|unique:providers',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'terms' => 'required|accepted',
        ]);
        
        // Handle file upload if a logo was provided
        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('logos', 'public');
        }
        
        // Create the provider record
        $provider = Provider::create([
            'user_id' => Auth::id(),
            'company_name' => $validatedData['company_name'],
            'company_logo' => $logoPath,
            'business_registration_number' => $validatedData['business_registration_number'],
            'contact_number' => $validatedData['contact_number'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'] ?? null,
            'status' => 'pending', // Default status for new providers
        ]);
        
        // Notify all admins: new provider registered
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin->id,
                NotificationService::NEW_PROVIDER,
                'New Provider Registration',
                "New provider \"{$validatedData['company_name']}\" has registered and is pending approval.",
                $provider->id
            );
        }

        // Redirect to provider dashboard or confirmation page
        return redirect()->route('provider.dashboard')->with('success', 'Provider registration completed successfully. Your account is now pending approval.');
    }
}