<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Route;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Total Providers
        $totalProviders = Provider::count();
        $newProviders = Provider::where('created_at', '>=', now()->subMonth())->count();

        // Total Buses
        $totalBuses = Bus::count();
        $activeBuses = Bus::where('status', 'active')->count();

        // Total Routes
        $totalRoutes = Route::count();
        $activeRoutes = Route::where('status', 'active')->count();

        // Total Revenue
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_amount');
        $lastMonthRevenue = Booking::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonth())
            ->sum('total_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100) : 0;

        // Pending Providers
        $pendingProviders = Provider::where('status', 'pending')->latest()->take(5)->get();

        // Recent Bookings
        $recentBookings = Booking::with('user')->latest()->take(5)->get();

        // Unread notifications for admin
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProviders',
            'newProviders',
            'totalBuses',
            'activeBuses',
            'totalRoutes',
            'activeRoutes',
            'totalRevenue',
            'revenueGrowth',
            'pendingProviders',
            'recentBookings',
            'notifications'
        ));
    }

    /**
     * Display all notifications for admin.
     */
    public function allNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Mark a single notification as read (admin).
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read (admin).
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}