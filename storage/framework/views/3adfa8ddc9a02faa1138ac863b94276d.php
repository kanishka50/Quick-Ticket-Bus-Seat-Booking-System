

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <?php if(session('success')): ?>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700"><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-primary to-primary-light rounded-md p-6 mb-6">
                    <h1 class="text-xl font-bold text-white">Admin Dashboard</h1>
                    <p class="text-sm text-indigo-100 mt-1">System overview and management</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Providers</p>
                                <p class="text-xl font-bold text-slate-900 mt-1"><?php echo e($totalProviders); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-emerald-600 font-medium"><i class="fas fa-arrow-up text-[10px]"></i> <?php echo e($newProviders); ?></span>
                            <span class="text-slate-400 ml-1.5">new this month</span>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Buses</p>
                                <p class="text-xl font-bold text-slate-900 mt-1"><?php echo e($totalBuses); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-emerald-50 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-slate-400"><?php echo e($activeBuses); ?> active buses</div>
                    </div>

                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Routes</p>
                                <p class="text-xl font-bold text-slate-900 mt-1"><?php echo e($totalRoutes); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-amber-50 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-slate-400"><?php echo e($activeRoutes); ?> active routes</div>
                    </div>

                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Revenue</p>
                                <p class="text-xl font-bold text-slate-900 mt-1">LKR <?php echo e(number_format($totalRevenue, 0)); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-purple-50 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-emerald-600 font-medium"><i class="fas fa-arrow-up text-[10px]"></i> <?php echo e(number_format($revenueGrowth, 1)); ?>%</span>
                            <span class="text-slate-400 ml-1.5">since last month</span>
                        </div>
                    </div>
                </div>

                <!-- Two Column Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Pending Provider Approvals -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-sm font-semibold text-slate-900">Pending Approvals</h2>
                            <a href="<?php echo e(route('admin.providers.index', ['status' => 'pending'])); ?>" class="text-xs font-medium text-primary hover:text-primary-dark">View All</a>
                        </div>
                        <?php if(count($pendingProviders) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Company</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Date</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <?php $__currentLoopData = $pendingProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-5 py-3">
                                            <span class="text-sm font-medium text-slate-900"><?php echo e($provider->company_name); ?></span>
                                            <span class="block text-xs text-slate-500"><?php echo e($provider->business_registration_number); ?></span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($provider->created_at->format('d M Y')); ?></td>
                                        <td class="px-5 py-3">
                                            <a href="<?php echo e(route('admin.providers.index', ['status' => 'pending'])); ?>" class="text-primary hover:text-primary-dark text-sm font-medium">Review</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-500">No pending approvals</p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-sm font-semibold text-slate-900">Recent Bookings</h2>
                            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-xs font-medium text-primary hover:text-primary-dark">View All</a>
                        </div>
                        <?php if(count($recentBookings) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Booking #</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Customer</th>
                                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Amount</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-2.5">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-5 py-3 text-sm font-medium text-slate-900"><?php echo e($booking->booking_number); ?></td>
                                        <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($booking->user->name); ?></td>
                                        <td class="px-5 py-3 text-sm text-slate-900 text-right">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                        <td class="px-5 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                                <?php if($booking->booking_status == 'confirmed'): ?> bg-emerald-50 text-emerald-700
                                                <?php elseif($booking->booking_status == 'pending'): ?> bg-amber-50 text-amber-700
                                                <?php elseif($booking->booking_status == 'cancelled'): ?> bg-red-50 text-red-700
                                                <?php else: ?> bg-primary/10 text-primary
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($booking->booking_status)); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-500">No recent bookings</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h2 class="text-sm font-semibold text-slate-900">Notifications</h2>
                        <div class="flex items-center gap-4">
                            <?php if($notifications->count() > 0): ?>
                                <button id="markAllRead" class="text-xs font-medium text-slate-500 hover:text-slate-700">Mark all as read</button>
                            <?php endif; ?>
                            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-xs font-medium text-primary hover:text-primary-dark">View All</a>
                        </div>
                    </div>

                    <?php if($notifications->count() > 0): ?>
                        <div class="divide-y divide-slate-50 max-h-80 overflow-y-auto" id="notifications-container">
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="px-5 py-3.5 hover:bg-slate-50/50 notification-item" data-id="<?php echo e($notification->id); ?>">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <?php echo $__env->make('partials.notification-icon', ['notification' => $notification], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-900"><?php echo e($notification->title); ?></p>
                                            <p class="text-sm text-slate-500 mt-0.5"><?php echo e($notification->message); ?></p>
                                            <?php if($notification->type == 'cancellation_request' && $notification->related_id): ?>
                                                <a href="<?php echo e(route('admin.bookings.index', ['schedule' => $notification->related_id])); ?>" class="text-xs text-primary hover:text-primary-dark font-medium mt-1 inline-block">View Affected Bookings →</a>
                                            <?php endif; ?>
                                            <p class="text-xs text-slate-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <button type="button" class="mark-read-btn ml-3 text-slate-400 hover:text-slate-600 shrink-0">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-500">No new notifications</p>
                        </div>
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
            fetch(`/admin/notifications/${notificationId}/mark-read`, {
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
                    notificationItem.remove();
                    if (document.querySelectorAll('.notification-item').length === 0) {
                        document.getElementById('notifications-container').innerHTML = '<div class="text-center py-8"><p class="text-sm text-slate-500">No new notifications</p></div>';
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
            fetch('/admin/notifications/mark-all-read', {
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
                    document.getElementById('notifications-container').innerHTML = '<div class="text-center py-8"><p class="text-sm text-slate-500">No new notifications</p></div>';
                    markAllReadButton.style.display = 'none';
                }
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>