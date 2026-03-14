@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.provider-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">All Bookings</h1>
                    <p class="text-sm text-slate-500 mt-1">View bookings for your buses</p>
                </div>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <!-- Status Filter Tabs -->
                    <div class="border-b border-slate-100">
                        <nav class="flex -mb-px px-5 space-x-6 overflow-x-auto" aria-label="Tabs">
                            @php
                                $tabs = [
                                    'all' => 'All',
                                    'pending' => 'Pending',
                                    'confirmed' => 'Confirmed',
                                    'cancelled' => 'Cancelled',
                                    'completed' => 'Completed',
                                ];
                            @endphp
                            @foreach($tabs as $key => $label)
                                <a href="{{ route('provider.bookings.index', ['status' => $key]) }}"
                                   class="whitespace-nowrap py-3 px-1 border-b-2 text-sm font-medium transition-colors
                                       {{ $status === $key
                                           ? 'border-primary text-primary'
                                           : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        @if($bookings->count() > 0)
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Booking #</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Customer</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Route</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Date</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Passengers</th>
                                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Amount</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Payment</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="px-5 py-3 text-sm font-medium text-slate-900">{{ $booking->booking_number }}</td>
                                            <td class="px-5 py-3 text-sm text-slate-600">{{ $booking->user->name }}</td>
                                            <td class="px-5 py-3 text-sm text-slate-600">
                                                {{ $booking->scheduleDate->schedule->route->origin->name }} → {{ $booking->scheduleDate->schedule->route->destination->name }}
                                            </td>
                                            <td class="px-5 py-3 text-sm text-slate-600">
                                                {{ \Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M, Y') }}
                                            </td>
                                            <td class="px-5 py-3 text-sm text-slate-600">{{ $booking->total_passengers }}</td>
                                            <td class="px-5 py-3 text-sm text-slate-900 text-right">LKR {{ number_format($booking->total_amount, 2) }}</td>
                                            <td class="px-5 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                                    {{ $booking->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                                    {{ ucfirst($booking->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                                    @if($booking->booking_status == 'confirmed') bg-emerald-50 text-emerald-700
                                                    @elseif($booking->booking_status == 'pending') bg-amber-50 text-amber-700
                                                    @elseif($booking->booking_status == 'cancelled') bg-red-50 text-red-700
                                                    @elseif($booking->booking_status == 'completed') bg-primary/10 text-primary
                                                    @endif">
                                                    {{ ucfirst($booking->booking_status) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <a href="{{ route('provider.bookings.show', $booking->id) }}"
                                                   class="text-primary hover:text-primary-dark text-sm font-medium">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-5 py-4 border-t border-slate-100">
                                {{ $bookings->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-ticket-alt text-slate-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900 mb-1">No bookings found</h3>
                                <p class="text-xs text-slate-500">
                                    @if($status !== 'all')
                                        No {{ $status }} bookings. <a href="{{ route('provider.bookings.index') }}" class="text-primary hover:text-primary-dark">View all bookings</a>
                                    @else
                                        There are no bookings for your buses yet.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
