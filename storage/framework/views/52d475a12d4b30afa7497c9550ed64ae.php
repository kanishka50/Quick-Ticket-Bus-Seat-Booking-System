

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8">Terms of Service</h1>

    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <p class="text-gray-500 text-sm">Last updated: <?php echo e(date('F Y')); ?></p>

        <div>
            <h2 class="text-xl font-semibold mb-3">1. Acceptance of Terms</h2>
            <p class="text-gray-700 leading-relaxed">
                By using QuickTicket, you agree to these terms of service. QuickTicket is an online platform that connects passengers with bus operators (providers) in Sri Lanka.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">2. Account Registration</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>You must create an account and verify your email to book tickets</li>
                <li>You are responsible for maintaining the security of your account</li>
                <li>You must provide accurate and complete information during registration</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">3. Booking & Payment</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>All prices are displayed in Sri Lankan Rupees (LKR)</li>
                <li>A booking is confirmed only after successful payment via PayHere</li>
                <li>Unpaid bookings remain in "pending" status and may be cancelled</li>
                <li>Seats are reserved upon booking — please complete payment promptly</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">4. Cancellation Policy</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li><strong>Unpaid bookings:</strong> You can cancel directly from your bookings page at no cost</li>
                <li><strong>Paid bookings:</strong> Contact the bus provider directly using the contact number on your booking detail page to request a cancellation</li>
                <li>Bookings cannot be cancelled after the bus has departed</li>
                <li>Refund policies are determined by individual bus providers</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">5. Passenger Responsibilities</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Arrive at the boarding point at least 15 minutes before departure</li>
                <li>Carry a valid ID and your booking confirmation (digital or printed)</li>
                <li>Follow the bus operator's rules and guidelines during travel</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">6. Bus Provider Responsibilities</h2>
            <p class="text-gray-700 leading-relaxed">
                Bus operators listed on QuickTicket are independent service providers. They are responsible for the actual bus service, schedule adherence, and passenger safety. QuickTicket acts as a booking intermediary and is not the transport operator.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">7. Live Tracking</h2>
            <p class="text-gray-700 leading-relaxed">
                Real-time bus tracking is available when a driver is assigned and has started the trip. Tracking accuracy depends on the driver's device and network connectivity. QuickTicket is not responsible for tracking inaccuracies.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">8. Limitation of Liability</h2>
            <p class="text-gray-700 leading-relaxed">
                QuickTicket is a booking platform and does not operate bus services. We are not liable for delays, cancellations, or service issues caused by bus operators. For trip-related issues, contact the bus provider directly.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">9. Contact</h2>
            <p class="text-gray-700 leading-relaxed">
                For questions about these terms, contact us at:
            </p>
            <p class="text-gray-700 mt-2">Email: info@quickticket.lk | Phone: +94 11 234 5678</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/pages/terms.blade.php ENDPATH**/ ?>