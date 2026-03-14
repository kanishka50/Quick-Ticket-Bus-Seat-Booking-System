

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="<?php echo e(route('provider.bookings.index')); ?>" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Booking #<?php echo e($booking->booking_number); ?></h1>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md
                        <?php if($booking->booking_status == 'confirmed'): ?> bg-emerald-50 text-emerald-700
                        <?php elseif($booking->booking_status == 'pending'): ?> bg-amber-50 text-amber-700
                        <?php elseif($booking->booking_status == 'cancelled'): ?> bg-red-50 text-red-700
                        <?php elseif($booking->booking_status == 'completed'): ?> bg-primary/10 text-primary
                        <?php endif; ?>">
                        <?php echo e(ucfirst($booking->booking_status)); ?>

                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md
                        <?php echo e($booking->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'); ?>">
                        <?php echo e(ucfirst($booking->payment_status)); ?>

                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Customer Details -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Customer Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Name:</span>
                                <span class="text-sm font-medium text-slate-900"><?php echo e($booking->user->name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Email:</span>
                                <span class="text-sm text-slate-600"><?php echo e($booking->user->email); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Trip Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Route:</span>
                                <span class="text-sm font-medium text-slate-900">
                                    <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?>

                                    →
                                    <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Departure Date:</span>
                                <span class="text-sm text-slate-600"><?php echo e(\Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Departure Time:</span>
                                <span class="text-sm text-slate-600"><?php echo e($booking->scheduleDate->schedule->departure_time); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Bus:</span>
                                <span class="text-sm text-slate-600"><?php echo e($booking->scheduleDate->schedule->bus->name ?? $booking->scheduleDate->schedule->bus->registration_number); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking & Payment Details -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Booking & Payment Details</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Passengers:</span>
                                <span class="text-sm text-slate-600"><?php echo e($booking->total_passengers); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Total Amount:</span>
                                <span class="text-sm font-medium text-slate-900">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Payment Status:</span>
                                <span class="text-sm font-medium <?php echo e($booking->payment_status == 'paid' ? 'text-emerald-600' : 'text-amber-600'); ?>">
                                    <?php echo e(ucfirst($booking->payment_status)); ?>

                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <?php if($booking->payment): ?>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Payment Method:</span>
                                    <span class="text-sm text-slate-600"><?php echo e(ucfirst($booking->payment_method ?? 'N/A')); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Transaction ID:</span>
                                    <span class="text-sm text-slate-600"><?php echo e($booking->payment->transaction_id); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Payment Date:</span>
                                    <span class="text-sm text-slate-600"><?php echo e($booking->payment->payment_date); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Booked On:</span>
                                <span class="text-sm text-slate-600"><?php echo e($booking->created_at->format('d M, Y h:i A')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seat Details -->
                <?php if($booking->seatBookings->isNotEmpty()): ?>
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Seat Details</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Seat Number</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php $__currentLoopData = $booking->seatBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-2.5 text-sm text-slate-900"><?php echo e($seat->seat_number); ?></td>
                                    <td class="px-4 py-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700">Booked</span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/bookings/show.blade.php ENDPATH**/ ?>