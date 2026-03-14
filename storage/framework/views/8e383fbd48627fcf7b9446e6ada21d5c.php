

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.driver-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Today's Trips</h1>
                    <p class="text-sm text-slate-500 mt-1">Your assigned trips for <?php echo e(now()->format('d M, Y')); ?></p>
                </div>

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

                <?php if($activeAssignment): ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-100 rounded-md flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-emerald-800">Active trip in progress</p>
                                <p class="text-xs text-emerald-600 mt-0.5">
                                    <?php echo e($activeAssignment->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($activeAssignment->scheduleDate->schedule->route->destination->name); ?>

                                </p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('driver.trip', $activeAssignment)); ?>" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md transition-colors shrink-0">
                            Go to Trip
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($todayAssignments->isEmpty()): ?>
                <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                    <div class="text-center py-16">
                        <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-slate-900">No trips assigned</h3>
                        <p class="text-xs text-slate-500 mt-1">You don't have any trips for today.</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $todayAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md
                                <?php if($assignment->status == 'active'): ?> bg-emerald-50 text-emerald-700
                                <?php elseif($assignment->status == 'completed'): ?> bg-primary/10 text-primary
                                <?php else: ?> bg-amber-50 text-amber-700
                                <?php endif; ?>">
                                <?php echo e(ucfirst($assignment->status)); ?>

                            </span>
                            <span class="text-xs text-slate-400"><?php echo e($assignment->scheduleDate->departure_date->format('d M Y')); ?></span>
                        </div>

                        <h3 class="text-base font-semibold text-slate-900 mb-3">
                            <?php echo e($assignment->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($assignment->scheduleDate->schedule->route->destination->name); ?>

                        </h3>

                        <div class="space-y-1.5 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <span><?php echo e($assignment->scheduleDate->schedule->bus->registration_number); ?> <?php echo e($assignment->scheduleDate->schedule->bus->name ? '- '.$assignment->scheduleDate->schedule->bus->name : ''); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span><?php echo e(\Carbon\Carbon::parse($assignment->scheduleDate->schedule->departure_time)->format('h:i A')); ?> — <?php echo e(\Carbon\Carbon::parse($assignment->scheduleDate->schedule->arrival_time)->format('h:i A')); ?></span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <?php if($assignment->status === 'assigned'): ?>
                            <form action="<?php echo e(route('driver.trip.start', $assignment)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md transition-colors"
                                    onclick="return confirm('Start this trip? Location sharing will begin.')">
                                    Start Trip
                                </button>
                            </form>
                            <?php elseif($assignment->status === 'active'): ?>
                            <a href="<?php echo e(route('driver.trip', $assignment)); ?>" class="block w-full text-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                View Active Trip
                            </a>
                            <?php else: ?>
                            <div class="flex items-center justify-center gap-2 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm text-slate-500">Trip completed</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/driver/dashboard.blade.php ENDPATH**/ ?>