

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="<?php echo e(route('provider.assignments.index')); ?>" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Assign Driver to Trip</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Assign a driver to a scheduled trip date</p>
                </div>

                <?php if($drivers->isEmpty()): ?>
                <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6">
                    <p class="text-sm text-amber-800">No active drivers available. <a href="<?php echo e(route('provider.drivers.create')); ?>" class="font-medium text-primary hover:text-primary-dark underline">Add a driver first</a>.</p>
                </div>
                <?php endif; ?>

                <?php if($schedules->isEmpty()): ?>
                <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6">
                    <p class="text-sm text-amber-800">No active schedules available.</p>
                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700"><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="<?php echo e(route('provider.assignments.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="driver_id" class="block text-sm font-medium text-slate-700 mb-1">Driver</label>
                                <select name="driver_id" id="driver_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Driver</option>
                                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($driver->id); ?>" <?php echo e(old('driver_id') == $driver->id ? 'selected' : ''); ?>>
                                            <?php echo e($driver->user->name); ?> (<?php echo e($driver->license_number); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['driver_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="schedule_id" class="block text-sm font-medium text-slate-700 mb-1">Schedule</label>
                                <select id="schedule_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Schedule</option>
                                    <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($schedule->id); ?>">
                                            <?php echo e($schedule->route->origin->name); ?> → <?php echo e($schedule->route->destination->name); ?> | <?php echo e(\Carbon\Carbon::parse($schedule->departure_time)->format('h:i A')); ?> - <?php echo e(\Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A')); ?> | Bus: <?php echo e($schedule->bus->registration_number); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label for="schedule_date_id" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                                <select name="schedule_date_id" id="schedule_date_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required disabled>
                                    <option value="">Select a schedule first</option>
                                </select>
                                <p id="dates-loading" class="text-xs text-slate-400 mt-1 hidden">Loading available dates...</p>
                                <?php $__errorArgs = ['schedule_date_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="<?php echo e(route('provider.assignments.index')); ?>" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Assign Driver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleSelect = document.getElementById('schedule_id');
    const dateSelect = document.getElementById('schedule_date_id');
    const loadingText = document.getElementById('dates-loading');

    scheduleSelect.addEventListener('change', function() {
        const scheduleId = this.value;

        dateSelect.innerHTML = '<option value="">Loading...</option>';
        dateSelect.disabled = true;

        if (!scheduleId) {
            dateSelect.innerHTML = '<option value="">Select a schedule first</option>';
            return;
        }

        loadingText.classList.remove('hidden');

        fetch(`/provider/assignments/schedule-dates/${scheduleId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(res => res.json())
        .then(dates => {
            loadingText.classList.add('hidden');

            if (dates.length === 0) {
                dateSelect.innerHTML = '<option value="">No unassigned dates available</option>';
                dateSelect.disabled = true;
                return;
            }

            let html = '<option value="">Select Date</option>';
            dates.forEach(d => {
                html += `<option value="${d.id}">${d.date} (${d.available_seats} seats available)</option>`;
            });
            dateSelect.innerHTML = html;
            dateSelect.disabled = false;
        })
        .catch(() => {
            loadingText.classList.add('hidden');
            dateSelect.innerHTML = '<option value="">Error loading dates</option>';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/assignments/create.blade.php ENDPATH**/ ?>