@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.driver-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Notifications</h1>
                    <p class="text-sm text-slate-500 mt-1">Your trip assignments and updates</p>
                </div>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-slate-900">All Notifications</h2>
                        @if($notifications->contains(fn($n) => !$n->is_read))
                            <button id="markAllRead" class="text-xs font-medium text-slate-400 hover:text-primary transition-colors">
                                Mark all as read
                            </button>
                        @endif
                    </div>

                    <div id="notifications-container">
                        @if($notifications->count() > 0)
                            <div class="divide-y divide-slate-100">
                                @foreach($notifications as $notification)
                                    <div class="px-5 py-4 notification-item hover:bg-slate-50/50 transition-colors {{ !$notification->is_read ? 'bg-primary/[0.02]' : '' }}" data-id="{{ $notification->id }}">
                                        <div class="flex items-start gap-3">
                                            <div class="shrink-0 mt-0.5">
                                                @include('partials.notification-icon', ['notification' => $notification])
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-900">{{ $notification->title }}</p>
                                                <p class="text-sm text-slate-500 mt-0.5">{{ $notification->message }}</p>
                                                <p class="text-xs text-slate-400 mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(!$notification->is_read)
                                            <button type="button" class="mark-read-btn shrink-0 text-slate-300 hover:text-slate-500 transition-colors mt-0.5" title="Mark as read">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                            @else
                                            <span class="shrink-0 text-xs text-slate-300 mt-0.5">Read</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="px-5 py-4 border-t border-slate-100">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="px-5 py-16 text-center">
                                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
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
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;

            fetch(`/driver/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.classList.remove('bg-primary/[0.02]');
                    const btn = notificationItem.querySelector('.mark-read-btn');
                    const readLabel = document.createElement('span');
                    readLabel.className = 'shrink-0 text-xs text-slate-300 mt-0.5';
                    readLabel.textContent = 'Read';
                    btn.replaceWith(readLabel);

                    const remaining = document.querySelectorAll('.mark-read-btn');
                    if (remaining.length === 0) {
                        const markAllBtn = document.getElementById('markAllRead');
                        if (markAllBtn) markAllBtn.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    const markAllReadButton = document.getElementById('markAllRead');
    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function() {
            fetch('/driver/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.classList.remove('bg-primary/[0.02]');
                        const btn = item.querySelector('.mark-read-btn');
                        if (btn) {
                            const readLabel = document.createElement('span');
                            readLabel.className = 'shrink-0 text-xs text-slate-300 mt-0.5';
                            readLabel.textContent = 'Read';
                            btn.replaceWith(readLabel);
                        }
                    });
                    this.style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
</script>
@endsection
