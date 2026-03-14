

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Select Your Seats</h1>
        </div>

        <!-- Schedule Details -->
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                        <i class="fas fa-bus text-primary"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900"><?php echo e($schedule->bus->name); ?></h2>
                        <p class="text-xs text-slate-500 mt-0.5"><?php echo e($schedule->bus->busType->name); ?></p>
                        <p class="text-sm text-slate-600 mt-1">
                            <?php echo e($schedule->route->origin->name); ?> → <?php echo e($schedule->route->destination->name); ?>

                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Date</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5"><?php echo e($scheduleDate->departure_date->format('d M Y')); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Departure</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5"><?php echo e(\Carbon\Carbon::parse($schedule->departure_time)->format('h:i A')); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Arrival</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5"><?php echo e(\Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Selection and Booking Summary -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Bus Layout Section -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Bus Layout</h2>

                    <!-- Front Indicator -->
                    <div class="text-center mb-5">
                        <div class="inline-flex items-center px-6 py-2 bg-slate-100 rounded-md text-xs font-medium text-slate-500 uppercase tracking-wide">
                            Front
                        </div>
                    </div>

                    <!-- Seat Layout -->
                    <?php
                        $availableSeats = array_filter($seatLayout, fn($s) => ($s['status'] ?? 'available') === 'available');
                        $layoutColumns = count($availableSeats) > 0 ? max(array_column($availableSeats, 'column')) + 1 : 4;
                    ?>
                    <div class="bus-layout my-4">
                        <div class="grid gap-3 justify-center" style="grid-template-columns: repeat(<?php echo e($layoutColumns); ?>, minmax(0, 1fr)); max-width: <?php echo e($layoutColumns * 72); ?>px; margin: 0 auto;">
                            <?php $__currentLoopData = $seatLayout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(($seat['status'] ?? 'available') === 'disabled'): ?>
                                    <?php continue; ?>
                                <?php endif; ?>
                                <?php
                                    $isSeatBooked = in_array($seat['number'], $bookedSeats);
                                ?>
                                <div class="seat-container">
                                    <div
                                        data-seat-id="<?php echo e($seat['id']); ?>"
                                        data-seat-number="<?php echo e($seat['number']); ?>"
                                        class="seat-div <?php echo e($isSeatBooked ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-600 text-white cursor-pointer'); ?>

                                        text-center rounded-md w-14 h-14 flex items-center justify-center transition-all duration-200 text-sm font-medium"
                                        <?php echo e($isSeatBooked ? 'disabled="disabled"' : ''); ?>>
                                        <?php echo e($seat['number']); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Seat Legend -->
                    <div class="flex justify-center items-center gap-6 mt-6 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-emerald-500 rounded-sm"></div>
                            <span class="text-xs text-slate-600">Available</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-slate-200 rounded-sm"></div>
                            <span class="text-xs text-slate-600">Booked</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-primary rounded-sm"></div>
                            <span class="text-xs text-slate-600">Selected</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary Section -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 sticky top-20">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Booking Summary</h2>
                    <form id="booking-form" action="<?php echo e(route('book.store', $schedule->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="date" value="<?php echo e($date); ?>">

                        <!-- Selected Seats Container -->
                        <div id="selected-seats-container" class="mb-4">
                            <p class="text-sm text-slate-400">No seats selected</p>
                        </div>

                        <!-- Price Summary -->
                        <div class="border-t border-slate-100 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-2 text-sm">
                                <span class="text-slate-500">Price per seat</span>
                                <span class="text-slate-700">LKR <?php echo e(number_format($schedule->price, 2)); ?></span>
                            </div>
                            <div class="flex justify-between items-center text-base font-semibold">
                                <span class="text-slate-900">Total</span>
                                <span id="total-price" class="text-primary">LKR 0.00</span>
                            </div>
                        </div>

                        <!-- Continue Button -->
                        <button type="submit" id="continue-btn"
                            class="w-full mt-5 inline-flex items-center justify-center px-4 py-2.5 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-arrow-right mr-2 text-xs"></i> Continue to Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initializeSeatSelection() {
        const seatDivs = document.querySelectorAll('.seat-div');
        const selectedSeatsContainer = document.getElementById('selected-seats-container');
        const totalPriceElement = document.getElementById('total-price');
        const continueBtn = document.getElementById('continue-btn');
        const bookingForm = document.getElementById('booking-form');

        const pricePerSeat = <?php echo e($schedule->price); ?>;
        let selectedSeats = [];

        seatDivs.forEach(seatDiv => {
            if (seatDiv.classList.contains('bg-slate-200')) {
                return;
            }

            seatDiv.addEventListener('click', function(event) {
                event.stopPropagation();

                const seatNumber = this.getAttribute('data-seat-number');
                const seatId = this.getAttribute('data-seat-id');

                if (this.classList.contains('bg-slate-200')) {
                    return;
                }

                const isSelected = this.classList.contains('bg-primary');

                if (isSelected) {
                    this.classList.remove('bg-primary', 'hover:bg-primary-dark');
                    this.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
                    selectedSeats = selectedSeats.filter(seat => seat.number !== seatNumber);
                } else {
                    this.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
                    this.classList.add('bg-primary', 'hover:bg-primary-dark');
                    selectedSeats.push({
                        number: seatNumber,
                        id: seatId
                    });
                }

                updateSelectedSeats();
            });
        });

        function updateSelectedSeats() {
            if (selectedSeats.length === 0) {
                selectedSeatsContainer.innerHTML = '<p class="text-sm text-slate-400">No seats selected</p>';
                totalPriceElement.textContent = 'LKR 0.00';
                continueBtn.disabled = true;
            } else {
                let html = '<div class="space-y-2">';

                selectedSeats.forEach((seat) => {
                    html += `
                        <div class="flex items-center justify-between px-3 py-2 bg-primary/5 border border-primary/10 rounded-md">
                            <span class="text-sm font-medium text-slate-700"><i class="fas fa-chair mr-2 text-primary text-xs"></i>Seat ${seat.number}</span>
                            <span class="text-sm text-slate-600">LKR ${pricePerSeat.toFixed(2)}</span>
                            <input type="hidden" name="seats[]" value="${seat.number}">
                            <input type="hidden" name="seat_ids[]" value="${seat.id}">
                        </div>
                    `;
                });

                html += '</div>';
                selectedSeatsContainer.innerHTML = html;

                const totalPrice = selectedSeats.length * pricePerSeat;
                totalPriceElement.textContent = `LKR ${totalPrice.toFixed(2)}`;
                continueBtn.disabled = false;
            }
        }

        bookingForm.addEventListener('submit', function(event) {
            if (selectedSeats.length === 0) {
                event.preventDefault();
                alert('Please select at least one seat');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSeatSelection);
    } else {
        initializeSeatSelection();
    }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/seat-selection.blade.php ENDPATH**/ ?>