

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="<?php echo e(route('provider.schedules.index')); ?>" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Edit Schedule</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Update schedule details</p>
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

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="<?php echo e(route('provider.schedules.update', $schedule)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="route_id" class="block text-sm font-medium text-slate-700 mb-1">Route</label>
                                <select name="route_id" id="route_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Route</option>
                                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($route->id); ?>" <?php echo e(old('route_id', $schedule->route_id) == $route->id ? 'selected' : ''); ?>>
                                            <?php echo e($route->origin->name); ?> → <?php echo e($route->destination->name); ?> (<?php echo e($route->distance); ?> km)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['route_id'];
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
                                <label for="bus_id" class="block text-sm font-medium text-slate-700 mb-1">Bus</label>
                                <select name="bus_id" id="bus_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Bus</option>
                                    <?php $__currentLoopData = $buses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bus->id); ?>" <?php echo e(old('bus_id', $schedule->bus_id) == $bus->id ? 'selected' : ''); ?>>
                                            <?php echo e($bus->registration_number); ?> <?php echo e($bus->name ? '- '.$bus->name : ''); ?> (<?php echo e($bus->busType->name); ?>, <?php echo e($bus->total_seats); ?> seats)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['bus_id'];
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
                                <label for="departure_time" class="block text-sm font-medium text-slate-700 mb-1">Departure Time</label>
                                <input type="time" name="departure_time" id="departure_time" value="<?php echo e(old('departure_time', $schedule->departure_time)); ?>"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                <?php $__errorArgs = ['departure_time'];
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
                                <label for="arrival_time" class="block text-sm font-medium text-slate-700 mb-1">Arrival Time</label>
                                <input type="time" name="arrival_time" id="arrival_time" value="<?php echo e(old('arrival_time', $schedule->arrival_time)); ?>"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                <?php $__errorArgs = ['arrival_time'];
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
                                <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Ticket Price (LKR)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm">LKR</span>
                                    </div>
                                    <input type="number" name="price" id="price" min="0.01" step="0.01" value="<?php echo e(old('price', $schedule->price)); ?>"
                                        class="w-full pl-12 pr-4 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="0.00" required>
                                </div>
                                <?php $__errorArgs = ['price'];
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
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="active" <?php echo e(old('status', $schedule->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                    <option value="inactive" <?php echo e(old('status', $schedule->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                </select>
                                <?php $__errorArgs = ['status'];
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
                            <a href="<?php echo e(route('provider.schedules.index')); ?>" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Update Schedule
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Active Bookings Warning -->
                <?php if($futureBookings->count() > 0): ?>
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6 mt-6">
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-amber-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <h2 class="text-sm font-semibold text-amber-700">Active Bookings on Future Dates (<?php echo e($futureBookings->count()); ?>)</h2>
                    </div>
                    <div class="border border-amber-200 bg-amber-50 rounded-md p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-amber-800">These bookings exist on future dates for this schedule. You cannot change the bus while these bookings are active.</p>
                            <form action="<?php echo e(route('provider.schedules.request-cancellation', $schedule)); ?>" method="POST" class="ml-4 flex-shrink-0">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 transition-colors" onclick="return confirm('This will send a cancellation request to admin for all <?php echo e($futureBookings->count()); ?> booking(s). Continue?')">
                                    Request Admin Cancellation
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Date</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Booking #</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Customer</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Seats</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Amount</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php $__currentLoopData = $futureBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-2.5 text-sm text-slate-900"><?php echo e($booking->scheduleDate->departure_date->format('d M Y')); ?></td>
                                    <td class="px-4 py-2.5 text-sm text-slate-900"><?php echo e($booking->booking_number); ?></td>
                                    <td class="px-4 py-2.5">
                                        <span class="text-sm text-slate-900"><?php echo e($booking->user->name); ?></span>
                                        <span class="block text-xs text-slate-500"><?php echo e($booking->user->email); ?></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-sm text-slate-600"><?php echo e($booking->seatBookings->pluck('seat_number')->join(', ')); ?></td>
                                    <td class="px-4 py-2.5 text-sm text-slate-900">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                    <td class="px-4 py-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            <?php echo e($booking->booking_status == 'confirmed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'); ?>">
                                            <?php echo e(ucfirst($booking->booking_status)); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Info Box -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-3">Schedule Availability</h2>
                    <p class="text-xs text-slate-500 mb-3">Once you have updated the schedule, you'll need to manage specific departure dates on which this schedule will operate.</p>

                    <div class="border border-primary/20 bg-primary/5 rounded-md p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-primary">Next Step: Manage Schedule Dates</h3>
                                <p class="text-xs text-slate-600 mt-1">After updating this schedule, go to "Manage Schedule Dates" to specify which dates this schedule will be available for booking.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departureTimeInput = document.getElementById('departure_time');
    const arrivalTimeInput = document.getElementById('arrival_time');

    function checkOvernight() {
        const departure = departureTimeInput.value;
        const arrival = arrivalTimeInput.value;
        let note = document.getElementById('overnight-note');

        if (departure && arrival && arrival <= departure) {
            if (!note) {
                note = document.createElement('p');
                note.id = 'overnight-note';
                note.className = 'text-xs text-amber-600 mt-1';
                note.textContent = 'Arrival is next day (overnight schedule)';
                arrivalTimeInput.parentNode.appendChild(note);
            }
        } else if (note) {
            note.remove();
        }
    }

    departureTimeInput.addEventListener('change', checkOvernight);
    arrivalTimeInput.addEventListener('change', checkOvernight);
    checkOvernight();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/schedules/edit.blade.php ENDPATH**/ ?>