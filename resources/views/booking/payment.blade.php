@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-2xl py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Complete Your Payment</h1>
            <p class="text-sm text-slate-500 mt-1">Review your booking details and proceed to pay.</p>
        </div>

        <!-- Booking Details -->
        <div class="bg-white border border-slate-100 rounded-md shadow-sm mb-6">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900 flex items-center">
                    <i class="fas fa-receipt mr-2 text-primary text-xs"></i> Booking Details
                </h2>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Booking Number</span>
                    <span class="font-medium text-slate-900">{{ $booking->booking_number }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Route</span>
                    <span class="text-slate-700">{{ $origin->name }} → {{ $destination->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Departure Date</span>
                    <span class="text-slate-700">{{ $scheduleDate->departure_date->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Departure Time</span>
                    <span class="text-slate-700">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</span>
                </div>
                <div class="flex justify-between text-sm pt-3 border-t border-slate-100">
                    <span class="font-semibold text-slate-900">Total Amount</span>
                    <span class="font-bold text-primary text-lg">LKR {{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- PayHere Payment Button -->
        <div class="bg-white border border-slate-100 rounded-md shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900 flex items-center">
                    <i class="fas fa-lock mr-2 text-primary text-xs"></i> Secure Payment
                </h2>
            </div>
            <div class="p-5">
                <p class="text-xs text-slate-500 mb-4">Your payment will be processed securely through PayHere. You'll be redirected to complete the transaction.</p>
                <button id="payButton" class="w-full inline-flex items-center justify-center px-4 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary-dark transition-colors">
                    <i class="fas fa-credit-card mr-2"></i> Pay Now with PayHere
                </button>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <i class="fab fa-cc-visa text-slate-400 text-xl"></i>
                    <i class="fab fa-cc-mastercard text-slate-400 text-xl"></i>
                    <i class="fas fa-university text-slate-400"></i>
                    <i class="fas fa-mobile-alt text-slate-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<script>
document.getElementById('payButton').addEventListener('click', function() {
    payWithPayHere();
});

function payWithPayHere() {
    var payment = {
        "sandbox": {{ env('PAYHERE_SANDBOX', true) ? 'true' : 'false' }},
        "merchant_id": "{{ $merchant_id }}",
        "return_url": "{{ route('payment.return') }}",
        "cancel_url": "{{ route('bookings.index') }}",
        "notify_url": "{{ env('PAYHERE_NOTIFY_URL') }}",
        "order_id": "{{ $order_id }}",
        "items": "Bus Ticket - {{ $origin->name }} to {{ $destination->name }}",
        "amount": "{{ $amount }}",
        "currency": "LKR",
        "hash": "{{ $hash }}",
        "first_name": "{{ Auth::user()->first_name }}",
        "last_name": "{{ Auth::user()->last_name }}",
        "email": "{{ Auth::user()->email }}",
        "phone": "{{ Auth::user()->phone ?? '' }}",
        "address": "{{ Auth::user()->address ?? '' }}",
        "city": "",
        "country": "Sri Lanka"
    };

    payhere.onCompleted = function onCompleted(orderID) {
        console.log("Payment completed. Order ID: " + orderID);
        window.location.href = "{{ route('payment.success', $booking->id) }}";
    };

    payhere.onDismissed = function onDismissed() {
        console.log("Payment dismissed");
        window.location.href = "{{ route('bookings.index') }}";
    };

    payhere.startPayment(payment);
}
</script>
@endsection
