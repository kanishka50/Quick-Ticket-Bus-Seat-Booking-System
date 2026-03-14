@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">About QuickTicket</h1>
        </div>

        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-base font-semibold text-slate-900 mb-2">Who We Are</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    QuickTicket is Sri Lanka's online bus ticket booking platform, connecting passengers with trusted bus operators across the island. We make it easy to search routes, compare schedules, select your preferred seats, and book tickets — all from the comfort of your home.
                </p>
            </div>

            <div>
                <h2 class="text-base font-semibold text-slate-900 mb-2">Our Mission</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    To simplify bus travel in Sri Lanka by providing a reliable, transparent, and convenient booking experience for passengers while empowering bus operators with modern tools to manage their fleets and schedules.
                </p>
            </div>

            <div>
                <h2 class="text-base font-semibold text-slate-900 mb-2">What We Offer</h2>
                <ul class="list-disc list-inside text-sm text-slate-600 space-y-1.5">
                    <li>Search and compare bus schedules across multiple routes</li>
                    <li>Interactive seat selection with real-time availability</li>
                    <li>Secure online payments via PayHere (Visa, MasterCard, bank transfer, mobile payments)</li>
                    <li>Real-time bus tracking with live map updates</li>
                    <li>Instant booking confirmations and digital receipts</li>
                    <li>Provider and driver contact details on your booking page</li>
                </ul>
            </div>

            <div>
                <h2 class="text-base font-semibold text-slate-900 mb-2">For Bus Operators</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Are you a bus operator? Register as a provider on QuickTicket to manage your buses, create schedules, assign drivers, and reach more customers. Our platform helps you streamline operations and grow your business.
                </p>
            </div>

            <div class="bg-primary/5 border border-primary/10 rounded-md p-5">
                <h2 class="text-base font-semibold text-slate-900 mb-3">Get In Touch</h2>
                <p class="text-sm text-slate-600 mb-3">Have questions or feedback? We'd love to hear from you.</p>
                <div class="space-y-2 text-sm text-slate-600">
                    <p><i class="fas fa-phone mr-2 text-primary text-xs"></i> +94 11 234 5678</p>
                    <p><i class="fas fa-envelope mr-2 text-primary text-xs"></i> info@quickticket.lk</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-primary text-xs"></i> 123 Main Street, Colombo, Sri Lanka</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
