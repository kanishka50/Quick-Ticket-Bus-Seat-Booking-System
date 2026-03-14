

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Bookings</a>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
    </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Booking #<?php echo e($booking->booking_number); ?></h1>
            <div class="flex items-center space-x-3">
                <?php if($booking->booking_status == 'confirmed'): ?>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                <?php elseif($booking->booking_status == 'pending'): ?>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                <?php elseif($booking->booking_status == 'cancelled'): ?>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                <?php elseif($booking->booking_status == 'completed'): ?>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Completed</span>
                <?php endif; ?>

                <?php if($booking->booking_status !== 'cancelled'): ?>
                <button onclick="document.getElementById('cancelModal').classList.remove('hidden')" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                    Cancel Booking
                </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Customer Details -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Customer Details</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium"><?php echo e($booking->user->name); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span><?php echo e($booking->user->email); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Trip Details -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Trip Details</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Route:</span>
                            <span class="font-medium">
                                <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?>

                                to
                                <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Departure Date:</span>
                            <span><?php echo e($booking->scheduleDate->departure_date->format('d M, Y')); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Departure Time:</span>
                            <span><?php echo e($booking->scheduleDate->schedule->departure_time); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bus:</span>
                            <span><?php echo e($booking->scheduleDate->schedule->bus->name ?? $booking->scheduleDate->schedule->bus->registration_number); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking & Payment Details -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Booking & Payment Details</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Passengers:</span>
                            <span><?php echo e($booking->total_passengers); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-medium">LKR <?php echo e(number_format($booking->total_amount, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <?php if($booking->payment_status == 'paid'): ?>
                                <span class="text-green-600 font-medium">Paid</span>
                            <?php else: ?>
                                <span class="text-yellow-600 font-medium"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <?php if($booking->payment): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span><?php echo e(ucfirst($booking->payment_method ?? 'N/A')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span><?php echo e($booking->payment->transaction_id); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Date:</span>
                                <span><?php echo e($booking->payment->payment_date); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Booked On:</span>
                            <span><?php echo e($booking->created_at->format('d M, Y h:i A')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Details -->
            <?php if($booking->seatBookings->isNotEmpty()): ?>
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Seat Details</h2>
                <div class="overflow-x-auto">
                    <table class="w-full bg-gray-50 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase">Seat Number</th>
                                <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $booking->seatBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo e($seat->seat_number); ?></td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        <?php echo e($booking->booking_status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                                        <?php echo e($booking->booking_status == 'cancelled' ? 'Cancelled' : 'Booked'); ?>

                                    </span>
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

<!-- Cancel Confirmation Modal -->
<?php if($booking->booking_status !== 'cancelled'): ?>
<div id="cancelModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Cancel Booking</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to cancel booking <strong>#<?php echo e($booking->booking_number); ?></strong>?</p>
                            <p class="text-sm text-gray-500 mt-1">Customer <strong><?php echo e($booking->user->name); ?></strong> and the provider will be notified.</p>
                            <?php if($booking->payment_status == 'paid'): ?>
                            <p class="text-sm text-red-600 mt-2 font-medium">Note: This booking has been paid. You may need to process a refund separately.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="<?php echo e(route('admin.bookings.cancel', $booking)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Cancel Booking
                    </button>
                </form>
                <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Go Back
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>