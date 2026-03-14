

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-primary to-primary-light rounded-md p-5 mb-6 text-white">
                    <h1 class="text-xl font-bold">Welcome, <?php echo e(auth()->user()->provider->company_name); ?></h1>
                    <p class="text-sm text-white/80 mt-1">Manage your buses, schedules, and bookings from here.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center">
                                <i class="fas fa-bus text-primary text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Active Buses</p>
                                <p class="text-xl font-bold text-slate-900"><?php echo e($activeBusesCount ?? 0); ?> <span class="text-xs font-normal text-slate-500">/ <?php echo e($totalBusesCount ?? 0); ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-md flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Active Schedules</p>
                                <p class="text-xl font-bold text-slate-900"><?php echo e($activeSchedulesCount ?? 0); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-50 rounded-md flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-accent text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Bookings This Month</p>
                                <p class="text-xl font-bold text-slate-900"><?php echo e($totalBookingsCount ?? 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mb-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="<?php echo e(route('provider.buses.create')); ?>" class="flex items-center p-3 border border-slate-100 rounded-md hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-plus text-primary text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Add New Bus</p>
                                <p class="text-xs text-slate-500">Add a bus to your fleet</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('provider.schedules.create')); ?>" class="flex items-center p-3 border border-slate-100 rounded-md hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-emerald-50 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Create Schedule</p>
                                <p class="text-xs text-slate-500">Set up a new bus schedule</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('provider.schedules.dates')); ?>" class="flex items-center p-3 border border-slate-100 rounded-md hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-violet-50 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-plus text-violet-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Manage Schedule Dates</p>
                                <p class="text-xs text-slate-500">Add dates to schedules</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('provider.drivers.create')); ?>" class="flex items-center p-3 border border-slate-100 rounded-md hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-amber-50 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-user-plus text-accent text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Add Driver</p>
                                <p class="text-xs text-slate-500">Register a new driver</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-sm font-semibold text-slate-900">Recent Bookings</h2>
                        <a href="<?php echo e(route('provider.bookings.index')); ?>" class="text-xs font-medium text-primary hover:text-primary-dark">View all</a>
                    </div>

                    <?php if(isset($recentBookings) && count($recentBookings) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide pb-3">Booking #</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide pb-3">Route</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide pb-3">Date</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide pb-3">Status</th>
                                    <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide pb-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="py-3 text-sm font-medium text-slate-900"><?php echo e($booking->booking_number); ?></td>
                                    <td class="py-3 text-sm text-slate-600">
                                        <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                                    </td>
                                    <td class="py-3 text-sm text-slate-600"><?php echo e($booking->scheduleDate->departure_date); ?></td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            <?php if($booking->booking_status == 'confirmed'): ?> bg-emerald-50 text-emerald-700
                                            <?php elseif($booking->booking_status == 'pending'): ?> bg-amber-50 text-amber-700
                                            <?php elseif($booking->booking_status == 'cancelled'): ?> bg-red-50 text-red-700
                                            <?php else: ?> bg-blue-50 text-blue-700 <?php endif; ?>">
                                            <?php echo e(ucfirst($booking->booking_status)); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 text-sm text-slate-900 text-right">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-ticket-alt text-slate-400"></i>
                        </div>
                        <p class="text-sm text-slate-500">No recent bookings found</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Notifications -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-sm font-semibold text-slate-900">Notifications</h2>
                        <div class="flex items-center gap-3">
                            <?php if(isset($notifications) && $notifications->count() > 0): ?>
                                <button id="markAllRead" class="text-xs font-medium text-slate-500 hover:text-slate-700">
                                    Mark all as read
                                </button>
                            <?php endif; ?>
                            <a href="<?php echo e(route('provider.notifications.index')); ?>" class="text-xs font-medium text-primary hover:text-primary-dark">View All</a>
                        </div>
                    </div>

                    <?php if(isset($notifications) && $notifications->count() > 0): ?>
                        <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto" id="notifications-container">
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="py-3 notification-item" data-id="<?php echo e($notification->id); ?>">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <?php echo $__env->make('partials.notification-icon', ['notification' => $notification], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm font-medium text-slate-900"><?php echo e($notification->title); ?></p>
                                            <p class="text-xs text-slate-500"><?php echo e($notification->message); ?></p>
                                            <p class="text-xs text-slate-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button type="button" class="mark-read-btn text-slate-400 hover:text-slate-500">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-slate-500">No new notifications.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const markReadButtons = document.querySelectorAll('.mark-read-btn');
    markReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;
            fetch(`/provider/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.remove();
                    if (document.querySelectorAll('.notification-item').length === 0) {
                        document.getElementById('notifications-container').innerHTML = '<p class="text-sm text-slate-500 py-3">No new notifications.</p>';
                        const markAllBtn = document.getElementById('markAllRead');
                        if (markAllBtn) markAllBtn.style.display = 'none';
                    }
                }
            });
        });
    });

    const markAllReadButton = document.getElementById('markAllRead');
    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function() {
            fetch('/provider/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifications-container').innerHTML = '<p class="text-sm text-slate-500 py-3">No new notifications.</p>';
                    markAllReadButton.style.display = 'none';
                }
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/dashboard.blade.php ENDPATH**/ ?>