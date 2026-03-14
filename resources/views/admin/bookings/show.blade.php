@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="{{ route('admin.bookings.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Booking #{{ $booking->booking_number }}</h1>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Status Badge & Cancel -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md
                        @if($booking->booking_status == 'confirmed') bg-emerald-50 text-emerald-700
                        @elseif($booking->booking_status == 'pending') bg-amber-50 text-amber-700
                        @elseif($booking->booking_status == 'cancelled') bg-red-50 text-red-700
                        @elseif($booking->booking_status == 'completed') bg-primary/10 text-primary
                        @endif">
                        {{ ucfirst($booking->booking_status) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md
                        {{ $booking->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                    @if($booking->booking_status !== 'cancelled')
                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                        class="ml-auto px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors">
                        Cancel Booking
                    </button>
                    @endif
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Customer Details -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Customer Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Name:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $booking->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Email:</span>
                                <span class="text-sm text-slate-600">{{ $booking->user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Trip Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Route:</span>
                                <span class="text-sm font-medium text-slate-900">
                                    {{ $booking->scheduleDate->schedule->route->origin->name }}
                                    →
                                    {{ $booking->scheduleDate->schedule->route->destination->name }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Departure Date:</span>
                                <span class="text-sm text-slate-600">{{ $booking->scheduleDate->departure_date->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Departure Time:</span>
                                <span class="text-sm text-slate-600">{{ $booking->scheduleDate->schedule->departure_time }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Bus:</span>
                                <span class="text-sm text-slate-600">{{ $booking->scheduleDate->schedule->bus->name ?? $booking->scheduleDate->schedule->bus->registration_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking & Payment Details -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Booking & Payment Details</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Passengers:</span>
                                <span class="text-sm text-slate-600">{{ $booking->total_passengers }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Total Amount:</span>
                                <span class="text-sm font-medium text-slate-900">LKR {{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Payment Status:</span>
                                <span class="text-sm font-medium {{ $booking->payment_status == 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @if($booking->payment)
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Payment Method:</span>
                                    <span class="text-sm text-slate-600">{{ ucfirst($booking->payment_method ?? 'N/A') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Transaction ID:</span>
                                    <span class="text-sm text-slate-600">{{ $booking->payment->transaction_id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Payment Date:</span>
                                    <span class="text-sm text-slate-600">{{ $booking->payment->payment_date }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-500">Booked On:</span>
                                <span class="text-sm text-slate-600">{{ $booking->created_at->format('d M, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seat Details -->
                @if($booking->seatBookings->isNotEmpty())
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Seat Details</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Seat Number</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-4 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($booking->seatBookings as $seat)
                                <tr>
                                    <td class="px-4 py-2.5 text-sm text-slate-900">{{ $seat->seat_number }}</td>
                                    <td class="px-4 py-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            {{ $booking->booking_status == 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">
                                            {{ $booking->booking_status == 'cancelled' ? 'Cancelled' : 'Booked' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
@if($booking->booking_status !== 'cancelled')
<div id="cancelModal" class="fixed inset-0 bg-slate-900/50 hidden overflow-y-auto h-full w-full z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-md shadow-lg border border-slate-200 max-w-md w-full">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-red-50 rounded-md flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-slate-900">Cancel Booking</h3>
                        <p class="text-sm text-slate-500 mt-2">Are you sure you want to cancel booking <strong>#{{ $booking->booking_number }}</strong>?</p>
                        <p class="text-sm text-slate-500 mt-1">Customer <strong>{{ $booking->user->name }}</strong> and the provider will be notified.</p>
                        @if($booking->payment_status == 'paid')
                        <p class="text-sm text-red-600 mt-2 font-medium">This booking has been paid. Refund must be handled separately.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')"
                    class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Go Back
                </button>
                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors">
                        Yes, Cancel Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
