

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-3xl py-8">
        <!-- Success Banner -->
        <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
            <div class="bg-emerald-500 px-5 py-5 text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <h1 class="text-xl font-bold text-white">Payment Successful</h1>
                <p class="text-emerald-100 text-sm mt-1">Your booking has been confirmed.</p>
            </div>

            <div class="p-5">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Booking Details -->
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                            <i class="fas fa-ticket-alt mr-2 text-primary text-xs"></i> Booking Details
                        </h2>
                        <div class="space-y-2.5">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Booking Number</span>
                                <span class="font-medium text-slate-900"><?php echo e($booking->booking_number); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Route</span>
                                <span class="text-slate-700">
                                    <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?>

                                    →
                                    <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Departure Date</span>
                                <span class="text-slate-700"><?php echo e($booking->scheduleDate->departure_date); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Departure Time</span>
                                <span class="text-slate-700"><?php echo e(\Carbon\Carbon::parse($booking->scheduleDate->schedule->departure_time)->format('h:i A')); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Passengers</span>
                                <span class="text-slate-700"><?php echo e($booking->total_passengers); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                            <i class="fas fa-credit-card mr-2 text-primary text-xs"></i> Payment Details
                        </h2>
                        <div class="space-y-2.5">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Total Amount</span>
                                <span class="font-semibold text-slate-900">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Transaction ID</span>
                                <span class="text-slate-700 font-mono text-xs"><?php echo e($booking->payment->transaction_id); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Payment Date</span>
                                <span class="text-slate-700"><?php echo e($booking->payment->payment_date); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Status</span>
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md <?php echo e($booking->payment->status == 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'); ?>">
                                    <?php echo e(ucfirst($booking->payment->status)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seat Details -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                        <i class="fas fa-chair mr-2 text-primary text-xs"></i> Seat Details
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $booking->seatBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="inline-flex items-center px-3 py-1.5 bg-primary/10 text-primary text-sm font-medium rounded-md">
                                <i class="fas fa-chair mr-1.5 text-xs"></i> <?php echo e($seat->seat_number); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                        <i class="fas fa-home mr-2 text-xs"></i> View My Bookings
                    </a>
                    <a href="<?php echo e(route('payment.print', $booking->id)); ?>" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition-colors">
                        <i class="fas fa-download mr-2 text-xs"></i> Download Receipt
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/booking/success.blade.php ENDPATH**/ ?>