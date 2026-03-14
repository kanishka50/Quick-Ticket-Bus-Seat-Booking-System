

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <?php echo $__env->make('partials.user-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <!-- Back Link -->
                <a href="<?php echo e(route('bookings.index')); ?>" class="inline-flex items-center text-sm text-slate-500 hover:text-primary transition-colors mb-4">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Bookings
                </a>

                <!-- Booking Header -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm mb-6">
                    <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h1 class="text-lg font-semibold text-slate-900">Booking #<?php echo e($booking->booking_number); ?></h1>
                            <p class="text-xs text-slate-500 mt-0.5">Booked on <?php echo e($booking->created_at->format('d M, Y h:i A')); ?></p>
                        </div>
                        <?php if($booking->booking_status == 'confirmed'): ?>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-emerald-50 text-emerald-700 self-start">Confirmed</span>
                        <?php elseif($booking->booking_status == 'pending'): ?>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-amber-50 text-amber-700 self-start">Pending</span>
                        <?php elseif($booking->booking_status == 'cancelled'): ?>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-red-50 text-red-700 self-start">Cancelled</span>
                        <?php elseif($booking->booking_status == 'completed'): ?>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 self-start">Completed</span>
                        <?php endif; ?>
                    </div>

                    <div class="p-5">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Trip Details -->
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                    <i class="fas fa-route mr-2 text-primary text-xs"></i> Trip Details
                                </h2>
                                <div class="space-y-2.5">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Route</span>
                                        <span class="font-medium text-slate-900">
                                            <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                                        </span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Departure Date</span>
                                        <span class="text-slate-700"><?php echo e(\Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y')); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Departure Time</span>
                                        <span class="text-slate-700"><?php echo e($booking->scheduleDate->schedule->departure_time); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Arrival Time</span>
                                        <span class="text-slate-700"><?php echo e($booking->scheduleDate->schedule->arrival_time); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Bus</span>
                                        <span class="text-slate-700"><?php echo e($booking->scheduleDate->schedule->bus->name ?? $booking->scheduleDate->schedule->bus->registration_number); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Reg No</span>
                                        <span class="text-slate-700"><?php echo e($booking->scheduleDate->schedule->bus->registration_number ?? 'N/A'); ?></span>
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
                                        <span class="text-slate-500">Payment Status</span>
                                        <?php if($booking->payment_status == 'paid'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700">Paid</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md bg-amber-50 text-amber-700"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($booking->payment): ?>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-slate-500">Transaction ID</span>
                                            <span class="text-slate-700 font-mono text-xs"><?php echo e($booking->payment->transaction_id); ?></span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-slate-500">Payment Date</span>
                                            <span class="text-slate-700"><?php echo e($booking->payment->payment_date); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Seat Details -->
                        <?php if($booking->seatBookings->isNotEmpty()): ?>
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
                        <?php endif; ?>

                        <!-- Provider & Driver Details -->
                        <div class="mt-6 pt-6 border-t border-slate-100 grid md:grid-cols-2 gap-6">
                            <?php if($booking->scheduleDate->schedule->bus->provider): ?>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                    <i class="fas fa-building mr-2 text-primary text-xs"></i> Provider Details
                                </h2>
                                <div class="space-y-2.5">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Company</span>
                                        <span class="font-medium text-slate-900"><?php echo e($booking->scheduleDate->schedule->bus->provider->company_name); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Contact</span>
                                        <a href="tel:<?php echo e($booking->scheduleDate->schedule->bus->provider->contact_number); ?>" class="text-primary hover:text-primary-dark transition-colors">
                                            <?php echo e($booking->scheduleDate->schedule->bus->provider->contact_number); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($booking->scheduleDate->driverAssignment && $booking->scheduleDate->driverAssignment->driver): ?>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                    <i class="fas fa-id-card mr-2 text-primary text-xs"></i> Driver Details
                                </h2>
                                <div class="space-y-2.5">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Name</span>
                                        <span class="font-medium text-slate-900"><?php echo e($booking->scheduleDate->driverAssignment->driver->user->name); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-500">Phone</span>
                                        <a href="tel:<?php echo e($booking->scheduleDate->driverAssignment->driver->phone); ?>" class="text-primary hover:text-primary-dark transition-colors">
                                            <?php echo e($booking->scheduleDate->driverAssignment->driver->phone); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                    <i class="fas fa-id-card mr-2 text-primary text-xs"></i> Driver Details
                                </h2>
                                <p class="text-sm text-slate-400">No driver assigned yet.</p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <?php if($booking->booking_status !== 'cancelled'): ?>
                                    <a href="<?php echo e(route('tracking.show', $booking->id)); ?>" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                                        <i class="fas fa-map-marker-alt mr-2 text-xs"></i> Track Bus
                                    </a>
                                <?php endif; ?>
                                <?php if($booking->payment_status == 'paid'): ?>
                                    <a href="<?php echo e(route('payment.print', $booking->id)); ?>" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition-colors">
                                        <i class="fas fa-download mr-2 text-xs"></i> Download Receipt
                                    </a>
                                <?php endif; ?>
                                <?php if($booking->payment_status != 'paid' && $booking->booking_status == 'pending'): ?>
                                    <a href="<?php echo e(route('payment.show', $booking->id)); ?>" class="inline-flex items-center px-4 py-2 bg-accent text-slate-900 text-sm font-semibold rounded-md hover:bg-accent-dark transition-colors">
                                        <i class="fas fa-wallet mr-2 text-xs"></i> Pay Now
                                    </a>
                                <?php endif; ?>
                            </div>

                            <?php if($booking->booking_status == 'pending' && $booking->payment_status != 'paid'): ?>
                                <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST"
                                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-md hover:bg-red-100 transition-colors border border-red-200">
                                        <i class="fas fa-times mr-2 text-xs"></i> Cancel Booking
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/user/booking-show.blade.php ENDPATH**/ ?>