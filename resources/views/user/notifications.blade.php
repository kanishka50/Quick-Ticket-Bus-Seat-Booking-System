@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            @include('partials.user-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h1 class="text-lg font-semibold text-slate-900">Notifications</h1>
                        <button id="markAllRead" class="text-xs font-medium text-slate-400 hover:text-primary transition-colors">
                            Mark all as read
                        </button>
                    </div>

                    <div id="notifications-container">
                        @if($notifications->count() > 0)
                            <div class="divide-y divide-slate-100">
                                @foreach($notifications as $notification)
                                    <div class="px-5 py-4 notification-item hover:bg-slate-50/50 transition-colors" data-id="{{ $notification->id }}">
                                        <div class="flex items-start gap-3">
                                            <div class="shrink-0 mt-0.5">
                                                @include('partials.notification-icon', ['notification' => $notification])
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-900">{{ $notification->title }}</p>
                                                <p class="text-sm text-slate-500 mt-0.5">{{ $notification->message }}</p>
                                                <p class="text-xs text-slate-400 mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            <button type="button" class="mark-read-btn shrink-0 text-slate-300 hover:text-slate-500 transition-colors mt-0.5" title="Dismiss">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="px-5 py-16 text-center">
                                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-bell text-slate-400 text-xl"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900">No notifications</h3>
                                <p class="text-xs text-slate-500 mt-1">You're all caught up!</p>
                            </div>
                        @endif
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
                            <div class="px-5 py-16 text-center">
                                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-bell text-slate-400 text-xl"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900">No notifications</h3>
                                <p class="text-xs text-slate-500 mt-1">You're all caught up!</p>
                            </div>`;
                        document.getElementById('markAllRead').style.display = 'none';
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
                        <div class="px-5 py-16 text-center">
                            <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bell text-slate-400 text-xl"></i>
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
