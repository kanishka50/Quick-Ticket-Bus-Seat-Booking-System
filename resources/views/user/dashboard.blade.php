@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            @include('partials.user-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-primary to-primary-light rounded-md p-6 mb-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-bold text-white">Welcome back, {{ $user->name }}!</h1>
                            <p class="text-indigo-100 text-sm mt-1">Here's your booking overview.</p>
                        </div>
                        <a href="/" class="inline-flex items-center px-4 py-2 bg-white/15 backdrop-blur-sm border border-white/20 text-white text-sm font-medium rounded-md hover:bg-white/25 transition-all">
                            <i class="fas fa-plus mr-2 text-xs"></i> Book New Ticket
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                                <i class="fas fa-ticket-alt text-primary"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Bookings</p>
                                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $totalBookings }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-50 rounded-md flex items-center justify-center shrink-0">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Completed</p>
                                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $completedBookings }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-amber-50 rounded-md flex items-center justify-center shrink-0">
                                <i class="fas fa-clock text-amber-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Upcoming</p>
                                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $pendingBookings }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <!-- Upcoming Trips -->
                    <div class="xl:col-span-2">
                        <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                                <h2 class="text-sm font-semibold text-slate-900">Upcoming Trips</h2>
                                <a href="{{ route('user.bookings') }}" class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">View all</a>
                            </div>

                            @if($upcomingTrips->count() > 0)
                                <div class="divide-y divide-slate-100">
                                    @foreach($upcomingTrips as $booking)
                                        <div class="px-5 py-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="flex items-start gap-3 min-w-0">
                                                    <div class="w-9 h-9 bg-primary/10 rounded-md flex items-center justify-center shrink-0 mt-0.5">
                                                        <i class="fas fa-bus text-primary text-sm"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium text-slate-900">
                                                            {{ $booking->scheduleDate->schedule->route->origin->name }} → {{ $booking->scheduleDate->schedule->route->destination->name }}
                                                        </p>
                                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1">
                                                            <span class="text-xs text-slate-500">
                                                                <i class="fas fa-calendar-alt mr-1 text-slate-400"></i>
                                                                {{ \Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y') }}
                                                            </span>
                                                            <span class="text-xs text-slate-500">
                                                                <i class="fas fa-clock mr-1 text-slate-400"></i>
                                                                {{ \Carbon\Carbon::parse($booking->scheduleDate->schedule->departure_time)->format('h:i A') }}
                                                            </span>
                                                            <span class="text-xs text-slate-500">
                                                                <i class="fas fa-user mr-1 text-slate-400"></i>
                                                                {{ $booking->total_passengers }} Passenger(s)
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center gap-3 mt-2">
                                                            @if($booking->booking_status == 'confirmed')
                                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700">Confirmed</span>
                                                            @elseif($booking->booking_status == 'pending')
                                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-amber-50 text-amber-700">Pending</span>
                                                            @endif
                                                            <span class="text-xs font-medium text-slate-700">LKR {{ number_format($booking->total_amount, 2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="shrink-0">
                                                    @if($booking->payment_status == 'pending' && $booking->booking_status == 'pending')
                                                        <a href="{{ route('payment.show', $booking->id) }}" class="inline-flex items-center px-3 py-1.5 bg-primary text-white text-xs font-medium rounded-md hover:bg-primary-dark transition-colors">
                                                            Pay Now
                                                        </a>
                                                    @else
                                                        <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-md hover:bg-slate-200 transition-colors">
                                                            View
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-5 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bus text-slate-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900">No upcoming trips</h3>
                                    <p class="text-xs text-slate-500 mt-1">Time to plan your next journey!</p>
                                    <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors mt-4">
                                        Book a Trip
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="xl:col-span-1">
                        <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                                <h2 class="text-sm font-semibold text-slate-900">Notifications</h2>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('user.notifications') }}" class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">View all</a>
                                    @if($notifications->count() > 0)
                                        <button id="markAllRead" class="text-xs font-medium text-slate-400 hover:text-slate-600 transition-colors">Mark all read</button>
                                    @endif
                                </div>
                            </div>

                            @if($notifications->count() > 0)
                                <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto" id="notifications-container">
                                    @foreach($notifications as $notification)
                                        <div class="px-5 py-3 notification-item hover:bg-slate-50 transition-colors" data-id="{{ $notification->id }}">
                                            <div class="flex items-start gap-3">
                                                <div class="shrink-0 mt-0.5">
                                                    @include('partials.notification-icon', ['notification' => $notification])
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $notification->title }}</p>
                                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                                                    <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                <button type="button" class="mark-read-btn shrink-0 text-slate-300 hover:text-slate-500 transition-colors mt-0.5">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-5 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bell text-slate-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900">No notifications</h3>
                                    <p class="text-xs text-slate-500 mt-1">You're all caught up!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings Table -->
                <div class="mt-6">
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-slate-900">Recent Bookings</h2>
                            <a href="{{ route('user.bookings') }}" class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">View all</a>
                        </div>

                        <div class="overflow-x-auto">
                            @if($recentBookings->count() > 0)
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50/50">
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Booking #</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Trip</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($recentBookings as $booking)
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-5 py-3.5 text-sm font-medium text-slate-900 whitespace-nowrap">{{ $booking->booking_number }}</td>
                                                <td class="px-5 py-3.5 text-sm text-slate-600 whitespace-nowrap">
                                                    {{ $booking->scheduleDate->schedule->route->origin->name }} → {{ $booking->scheduleDate->schedule->route->destination->name }}
                                                </td>
                                                <td class="px-5 py-3.5 text-sm text-slate-600 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y') }}
                                                </td>
                                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700 whitespace-nowrap">
                                                    LKR {{ number_format($booking->total_amount, 2) }}
                                                </td>
                                                <td class="px-5 py-3.5 whitespace-nowrap">
                                                    @if($booking->booking_status == 'confirmed')
                                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700">Confirmed</span>
                                                    @elseif($booking->booking_status == 'pending')
                                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-amber-50 text-amber-700">Pending</span>
                                                    @elseif($booking->booking_status == 'cancelled')
                                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-red-50 text-red-700">Cancelled</span>
                                                    @elseif($booking->booking_status == 'completed')
                                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700">Completed</span>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3.5 whitespace-nowrap">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('bookings.show', $booking->id) }}" class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">View</a>
                                                        @if($booking->payment_status == 'pending' && $booking->booking_status == 'pending')
                                                            <a href="{{ route('payment.show', $booking->id) }}" class="inline-flex items-center px-2.5 py-1 bg-primary text-white text-xs font-medium rounded-md hover:bg-primary-dark transition-colors">
                                                                Pay Now
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="px-5 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-receipt text-slate-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900">No bookings yet</h3>
                                    <p class="text-xs text-slate-500 mt-1">Get started by creating a new booking.</p>
                                    <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors mt-4">
                                        Book a Trip
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark single notification as read
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;

            fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.remove();
                    const remaining = document.querySelectorAll('.notification-item');
                    if (remaining.length === 0) {
                        document.getElementById('notifications-container').innerHTML = `
                            <div class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-bell text-slate-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900">No notifications</h3>
                                <p class="text-xs text-slate-500 mt-1">You're all caught up!</p>
                            </div>`;
                        const markAllBtn = document.getElementById('markAllRead');
                        if (markAllBtn) markAllBtn.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Mark all notifications as read
    const markAllReadButton = document.getElementById('markAllRead');
    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifications-container').innerHTML = `
                        <div class="px-5 py-12 text-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-bell text-slate-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900">No notifications</h3>
                            <p class="text-xs text-slate-500 mt-1">You're all caught up!</p>
                        </div>`;
                    this.style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
</script>
@endsection
