

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <?php echo $__env->make('partials.user-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h1 class="text-lg font-semibold text-slate-900">My Bookings</h1>
                    </div>

                    <div class="overflow-x-auto">
                        <?php if($bookings->count() > 0): ?>
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
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-5 py-3.5 text-sm font-medium text-slate-900 whitespace-nowrap"><?php echo e($booking->booking_number); ?></td>
                                            <td class="px-5 py-3.5 text-sm text-slate-600 whitespace-nowrap">
                                                <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                                            </td>
                                            <td class="px-5 py-3.5 text-sm text-slate-600 whitespace-nowrap">
                                                <?php echo e(\Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y')); ?>

                                            </td>
                                            <td class="px-5 py-3.5 text-sm font-medium text-slate-700 whitespace-nowrap">
                                                LKR <?php echo e(number_format($booking->total_amount, 2)); ?>

                                            </td>
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <?php if($booking->booking_status == 'confirmed'): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700">Confirmed</span>
                                                <?php elseif($booking->booking_status == 'pending'): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-amber-50 text-amber-700">Pending</span>
                                                <?php elseif($booking->booking_status == 'cancelled'): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-red-50 text-red-700">Cancelled</span>
                                                <?php elseif($booking->booking_status == 'completed'): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700">Completed</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <a href="<?php echo e(route('bookings.show', $booking->id)); ?>" class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">View</a>
                                                    <?php if($booking->payment_status == 'pending' && $booking->booking_status == 'pending'): ?>
                                                        <a href="<?php echo e(route('payment.show', $booking->id)); ?>" class="inline-flex items-center px-2.5 py-1 bg-primary text-white text-xs font-medium rounded-md hover:bg-primary-dark transition-colors">
                                                            Pay Now
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="px-5 py-16 text-center">
                                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-ticket-alt text-slate-400 text-xl"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900">No bookings yet</h3>
                                <p class="text-xs text-slate-500 mt-1">Get started by creating a new booking.</p>
                                <a href="<?php echo e(route('search')); ?>" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors mt-4">
                                    Book a Trip
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/user/bookings.blade.php ENDPATH**/ ?>