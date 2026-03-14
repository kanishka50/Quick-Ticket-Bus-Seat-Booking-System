

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="<?php echo e(route('provider.buses.index')); ?>" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Edit Bus</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Update bus details for <?php echo e($bus->registration_number); ?></p>
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
                    <form action="<?php echo e(route('provider.buses.update', $bus)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="registration_number" class="block text-sm font-medium text-slate-700 mb-1">Registration Number</label>
                                <input type="text" name="registration_number" id="registration_number" value="<?php echo e(old('registration_number', $bus->registration_number)); ?>"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                <?php $__errorArgs = ['registration_number'];
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
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Bus Name (Optional)</label>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name', $bus->name)); ?>"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                <?php $__errorArgs = ['name'];
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
                                <label for="bus_type_id" class="block text-sm font-medium text-slate-700 mb-1">Bus Type</label>
                                <select name="bus_type_id" id="bus_type_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Bus Type</option>
                                    <?php $__currentLoopData = $busTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $busType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($busType->id); ?>" <?php echo e(old('bus_type_id', $bus->bus_type_id) == $busType->id ? 'selected' : ''); ?>>
                                            <?php echo e($busType->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['bus_type_id'];
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
                                <label class="block text-sm font-medium text-slate-700 mb-1">Total Seats</label>
                                <p id="total-seats-display" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-md text-sm text-slate-600"><?php echo e($bus->total_seats); ?> seats</p>
                                <p class="text-xs text-slate-500 mt-1">Auto-calculated from seat layout. Click seats to disable/enable them.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="active" <?php echo e(old('status', $bus->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                    <option value="inactive" <?php echo e(old('status', $bus->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                    <option value="maintenance" <?php echo e(old('status', $bus->status) == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
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

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-3">Seat Layout</label>
                                <div id="seat-layout-builder" class="border border-slate-200 rounded-md p-4 bg-slate-50">
                                    <div class="flex justify-between mb-4">
                                        <div>
                                            <label for="rows" class="block text-xs text-slate-600 mb-1">Rows</label>
                                            <input type="number" id="rows" min="1" max="20" value="10"
                                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                        </div>
                                        <div>
                                            <label for="columns" class="block text-xs text-slate-600 mb-1">Columns</label>
                                            <input type="number" id="columns" min="1" max="6" value="4"
                                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                        </div>
                                        <div class="pt-5">
                                            <button type="button" id="generate-layout" class="py-2 px-4 bg-primary text-white text-sm rounded-md hover:bg-primary-dark transition-colors">Generate</button>
                                        </div>
                                    </div>
                                    <div id="seat-grid" class="mb-4 grid grid-cols-4 gap-2">
                                        <!-- Seats will be generated here -->
                                    </div>
                                    <input type="hidden" name="seat_layout" id="seat-layout-json" value="<?php echo e(old('seat_layout', $bus->seat_layout)); ?>">
                                </div>
                                <?php $__errorArgs = ['seat_layout'];
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

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-3">Amenities</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <?php $busAmenities = json_decode($bus->amenities) ?? []; ?>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="AC" <?php echo e(in_array('AC', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">Air Conditioning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="WiFi" <?php echo e(in_array('WiFi', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">WiFi</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="USB" <?php echo e(in_array('USB', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">USB Charging</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="TV" <?php echo e(in_array('TV', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">TV</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Toilet" <?php echo e(in_array('Toilet', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">Toilet</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Blanket" <?php echo e(in_array('Blanket', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">Blanket</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Reclining" <?php echo e(in_array('Reclining', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">Reclining Seats</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Water" <?php echo e(in_array('Water', $busAmenities) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-slate-600">Water Bottle</span>
                                    </label>
                                </div>
                                <input type="hidden" name="amenities" id="amenities-json" value="<?php echo e(old('amenities', $bus->amenities)); ?>">
                                <?php $__errorArgs = ['amenities'];
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
                            <a href="<?php echo e(route('provider.buses.index')); ?>" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Update Bus
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
    const existingLayout = <?php echo json_encode(json_decode($bus->seat_layout), 15, 512) ?>;

    let maxRow = 0;
    let maxColumn = 0;

    if (existingLayout && existingLayout.length > 0) {
        existingLayout.forEach(seat => {
            maxRow = Math.max(maxRow, seat.row);
            maxColumn = Math.max(maxColumn, seat.column);
        });
        document.getElementById('rows').value = maxRow + 1;
        document.getElementById('columns').value = maxColumn + 1;
    }

    const generateLayout = document.getElementById('generate-layout');
    generateLayout.addEventListener('click', function() {
        const rows = parseInt(document.getElementById('rows').value) || 10;
        const columns = parseInt(document.getElementById('columns').value) || 4;

        if (rows > 20 || columns > 6) {
            alert('Maximum rows: 20, Maximum columns: 6');
            return;
        }

        const seatGrid = document.getElementById('seat-grid');
        seatGrid.innerHTML = '';
        seatGrid.style.gridTemplateColumns = `repeat(${columns}, minmax(0, 1fr))`;

        let seatNumber = 1;
        const seatLayout = [];

        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                const seat = document.createElement('div');
                const seatId = `seat-${i}-${j}`;
                const seatDisplay = String.fromCharCode(65 + i) + (j + 1);

                seat.id = seatId;
                seat.dataset.row = i;
                seat.dataset.column = j;
                seat.dataset.number = seatNumber++;
                seat.textContent = seatDisplay;

                let isDisabled = false;
                if (existingLayout) {
                    const existingSeat = existingLayout.find(s => s.row === i && s.column === j);
                    if (existingSeat && existingSeat.status === 'disabled') {
                        isDisabled = true;
                    }
                }

                if (isDisabled) {
                    seat.className = 'seat bg-slate-200 text-slate-400 text-center py-2 rounded-md cursor-pointer hover:bg-slate-300 text-sm font-medium';
                } else {
                    seat.className = 'seat bg-primary/10 text-primary text-center py-2 rounded-md cursor-pointer hover:bg-primary/20 text-sm font-medium';
                }

                seat.addEventListener('click', function() {
                    if (this.classList.contains('bg-slate-200')) {
                        this.classList.remove('bg-slate-200', 'text-slate-400');
                        this.classList.add('bg-primary/10', 'text-primary');
                    } else {
                        this.classList.remove('bg-primary/10', 'text-primary');
                        this.classList.add('bg-slate-200', 'text-slate-400');
                    }
                    updateSeatLayout();
                });

                seatGrid.appendChild(seat);

                seatLayout.push({
                    id: seatId,
                    number: seatDisplay,
                    row: i,
                    column: j,
                    status: isDisabled ? 'disabled' : 'available'
                });
            }
        }

        document.getElementById('seat-layout-json').value = JSON.stringify(seatLayout);
        updateSeatCount();
    });

    generateLayout.click();

    function updateSeatLayout() {
        const seats = document.querySelectorAll('#seat-grid .seat');
        const seatLayout = [];

        seats.forEach(seat => {
            seatLayout.push({
                id: seat.id,
                number: seat.textContent,
                row: parseInt(seat.dataset.row),
                column: parseInt(seat.dataset.column),
                status: seat.classList.contains('bg-slate-200') ? 'disabled' : 'available'
            });
        });

        document.getElementById('seat-layout-json').value = JSON.stringify(seatLayout);
        updateSeatCount();
    }

    function updateSeatCount() {
        const seats = document.querySelectorAll('#seat-grid .seat');
        let available = 0;
        let disabled = 0;
        seats.forEach(seat => {
            if (seat.classList.contains('bg-slate-200')) {
                disabled++;
            } else {
                available++;
            }
        });
        const display = document.getElementById('total-seats-display');
        if (disabled > 0) {
            display.textContent = `${available} available seats (${disabled} disabled)`;
        } else {
            display.textContent = `${available} seats`;
        }
    }

    const amenityCheckboxes = document.querySelectorAll('.amenity-checkbox');
    amenityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateAmenities);
    });

    function updateAmenities() {
        const amenities = [];
        document.querySelectorAll('.amenity-checkbox:checked').forEach(checkbox => {
            amenities.push(checkbox.value);
        });
        document.getElementById('amenities-json').value = JSON.stringify(amenities);
    }

    updateAmenities();

    if (existingLayout && existingLayout.length > 0) {
        const seats = document.querySelectorAll('#seat-grid .seat');
        seats.forEach(seat => {
            const row = parseInt(seat.dataset.row);
            const column = parseInt(seat.dataset.column);
            const existingSeat = existingLayout.find(s => s.row === row && s.column === column);

            if (existingSeat && existingSeat.status === 'disabled') {
                seat.classList.remove('bg-primary/10', 'text-primary');
                seat.classList.add('bg-slate-200', 'text-slate-400');
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/buses/edit.blade.php ENDPATH**/ ?>