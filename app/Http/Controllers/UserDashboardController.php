<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get recent bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->with(['scheduleDate.schedule.bus', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get upcoming trips
        $upcomingTrips = Booking::select('bookings.*')
        ->where('bookings.user_id', $user->id)
        ->whereIn('bookings.booking_status', ['confirmed', 'pending'])
        ->whereHas('scheduleDate', function($query) {
            $query->where('departure_date', '>=', now()->format('Y-m-d'));
        })
        ->with(['scheduleDate.schedule.bus', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination'])
        ->join('schedule_dates', 'bookings.schedule_date_id', '=', 'schedule_dates.id')
        ->orderBy('schedule_dates.departure_date', 'asc')
        ->take(3)
        ->get();
        
        // Get unread notifications
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get booking statistics
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('booking_status', 'completed')
            ->count();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->count();
        
        return view('user.dashboard', compact(
            'user',
            'recentBookings',
            'upcomingTrips',
            'notifications',
            'totalBookings',
            'completedBookings',
            'pendingBookings'
        ));
    }
    
    /**
     * Mark notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Get all notifications for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.notifications', compact('notifications'));
    }

     /**
     * Get all bookings for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function allBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['scheduleDate.schedule.bus', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.bookings', compact('bookings'));
    }


}