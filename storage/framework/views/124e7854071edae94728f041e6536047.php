

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Available Schedules</h1>
            <p class="text-sm text-slate-500 mt-1">
                Showing schedules from <span class="font-medium text-slate-700"><?php echo e($origin->name); ?></span>
                to <span class="font-medium text-slate-700"><?php echo e($destination->name); ?></span>
                on <span class="font-medium text-slate-700"><?php echo e(request('date')); ?></span>
            </p>
        </div>

        <?php if($noSchedules): ?>
            <div class="bg-white border border-slate-100 rounded-md shadow-sm p-12 text-center">
                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bus text-slate-400 text-xl"></i>
                </div>
                <h3 class="text-sm font-medium text-slate-900">No schedules available</h3>
                <p class="text-xs text-slate-500 mt-1">Try a different date or route.</p>
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors mt-4">
                    <i class="fas fa-search mr-2 text-xs"></i> Search Again
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <!-- Bus Info -->
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                                        <i class="fas fa-bus text-primary"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-semibold text-slate-900"><?php echo e($schedule->bus->name ?? $schedule->bus->registration_number); ?></h2>
                                        <p class="text-xs text-slate-500 mt-0.5"><?php echo e($schedule->bus->busType->name); ?></p>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2">
                                            <span class="text-xs text-slate-500">
                                                <i class="fas fa-id-card mr-1 text-slate-400"></i><?php echo e($schedule->bus->registration_number); ?>

                                            </span>
                                            <?php if($schedule->bus->provider): ?>
                                                <span class="text-xs text-slate-500">
                                                    <i class="fas fa-building mr-1 text-slate-400"></i><?php echo e($schedule->bus->provider->company_name); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Info -->
                                <div class="flex items-center gap-6 md:text-right">
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">Departure</p>
                                        <p class="text-base font-semibold text-slate-900 mt-0.5"><?php echo e(\Carbon\Carbon::parse($schedule->departure_time)->format('h:i A')); ?></p>
                                    </div>
                                    <div class="text-slate-300">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">Arrival</p>
                                        <p class="text-base font-semibold text-slate-900 mt-0.5"><?php echo e(\Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Bar -->
                            <?php
                                $departureDateTime = \Carbon\Carbon::parse(request('date') . ' ' . $schedule->departure_time);
                                $hasDeparted = now()->gt($departureDateTime);
                            ?>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mt-4 pt-4 border-t border-slate-100">
                                <div class="flex flex-wrap items-center gap-4">
                                    <span class="text-sm font-semibold text-slate-900">
                                        LKR <?php echo e(number_format($schedule->price, 2)); ?>

                                        <span class="text-xs font-normal text-slate-500">/seat</span>
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md <?php echo e($schedule->scheduleDates->first()->available_seats > 5 ? 'bg-emerald-50 text-emerald-700' : ($schedule->scheduleDates->first()->available_seats > 0 ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')); ?>">
                                        <i class="fas fa-chair mr-1"></i>
                                        <?php echo e($schedule->scheduleDates->first()->available_seats); ?> seats available
                                    </span>
                                </div>

                                <?php if($hasDeparted): ?>
                                    <span class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-400 text-sm font-medium rounded-md cursor-not-allowed">
                                        <i class="fas fa-clock mr-2 text-xs"></i> Departed
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e(route('book', ['schedule' => $schedule->id, 'date' => request('date')])); ?>" class="inline-flex items-center px-5 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                                        <i class="fas fa-ticket-alt mr-2 text-xs"></i> Book Now
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/booking/schedules.blade.php ENDPATH**/ ?>