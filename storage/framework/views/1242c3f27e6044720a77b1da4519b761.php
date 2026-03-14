

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8">Privacy Policy</h1>

    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <p class="text-gray-500 text-sm">Last updated: <?php echo e(date('F Y')); ?></p>

        <div>
            <h2 class="text-xl font-semibold mb-3">1. Information We Collect</h2>
            <p class="text-gray-700 leading-relaxed mb-2">When you use QuickTicket, we collect the following information:</p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li><strong>Account Information:</strong> Name, email address, phone number, and address when you register</li>
                <li><strong>Booking Information:</strong> Travel dates, routes, seat selections, and payment details</li>
                <li><strong>Payment Information:</strong> Processed securely through PayHere — we do not store your card details</li>
                <li><strong>Location Data:</strong> Bus location data for real-time tracking (drivers only)</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">2. How We Use Your Information</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Process and manage your bus ticket bookings</li>
                <li>Send booking confirmations and notifications</li>
                <li>Provide real-time bus tracking to passengers</li>
                <li>Communicate important updates about your trips</li>
                <li>Improve our platform and services</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">3. Information Sharing</h2>
            <p class="text-gray-700 leading-relaxed">
                We share your booking details with the relevant bus provider to fulfill your trip. Provider and driver contact information is displayed on your booking page so you can reach them directly. We do not sell your personal information to third parties.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">4. Payment Security</h2>
            <p class="text-gray-700 leading-relaxed">
                All payments are processed through PayHere, a PCI DSS compliant payment gateway. Your card details are handled directly by PayHere and are never stored on our servers.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">5. Data Retention</h2>
            <p class="text-gray-700 leading-relaxed">
                We retain your account and booking data for as long as your account is active. You can request deletion of your account by contacting us at info@quickticket.lk.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3">6. Contact Us</h2>
            <p class="text-gray-700 leading-relaxed">
                If you have questions about this privacy policy, contact us at:
            </p>
            <p class="text-gray-700 mt-2">Email: info@quickticket.lk | Phone: +94 11 234 5678</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/pages/privacy.blade.php ENDPATH**/ ?>