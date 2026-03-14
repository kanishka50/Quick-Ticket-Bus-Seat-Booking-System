@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Contact Us</h1>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-5">Get In Touch</h2>

                <div class="space-y-5">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                            <i class="fas fa-phone text-primary text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-900">Phone</h3>
                            <p class="text-sm text-slate-600">+94 11 234 5678</p>
                            <p class="text-xs text-slate-500 mt-0.5">Mon - Sat, 8:00 AM - 6:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-primary text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-900">Email</h3>
                            <p class="text-sm text-slate-600">info@quickticket.lk</p>
                            <p class="text-xs text-slate-500 mt-0.5">We'll respond within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                            <i class="fas fa-map-marker-alt text-primary text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-900">Office Address</h3>
                            <p class="text-sm text-slate-600">123 Main Street, Colombo 03</p>
                            <p class="text-sm text-slate-600">Sri Lanka</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-5">Frequently Asked</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-slate-900 mb-1">Booking Issues</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">If you're having trouble with a booking, check your booking details page for provider contact information, or reach us via phone/email.</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-slate-900 mb-1">Payment Problems</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">If your payment failed, you can retry from your bookings page using the "Pay Now" button. For payment disputes, contact us with your booking number.</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-slate-900 mb-1">Cancellations & Refunds</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Unpaid bookings can be cancelled from your bookings page. For paid booking cancellations, contact the bus provider directly — their contact number is on your booking detail page.</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-slate-900 mb-1">Become a Provider</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Register an account and complete the provider onboarding process. Our admin team will review and approve your application.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
