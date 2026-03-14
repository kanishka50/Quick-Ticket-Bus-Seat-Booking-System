@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Booking Management</h1>
                    <p class="text-sm text-slate-500 mt-1">View and manage all bookings</p>
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

                @if(isset($schedule) && $schedule)
                <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-amber-500 mr-2 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-amber-800">Showing bookings for: {{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }}</p>
                                <p class="text-xs text-amber-600">Bus: {{ $schedule->bus->registration_number }} {{ $schedule->bus->name ? '- '.$schedule->bus->name : '' }} | Provider requested cancellation for bus change</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-amber-700 hover:text-amber-900 font-medium shrink-0 ml-4">Clear Filter</a>
                    </div>
                </div>
                @endif

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
                                $scheduleParam = isset($schedule) && $schedule ? ['schedule' => $schedule->id] : [];
                            @endphp
                            @foreach($tabs as $key => $label)
                                <a href="{{ route('admin.bookings.index', array_merge(['status' => $key], $scheduleParam)) }}"
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
                                    <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($bookings as $booking)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-sm font-medium text-slate-900">{{ $booking->booking_number }}</td>
                                    <td class="px-5 py-3">
                                        <span class="text-sm text-slate-900">{{ $booking->user->name }}</span>
                                        <span class="block text-xs text-slate-500">{{ $booking->user->email }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-slate-600">
                                        @if($booking->scheduleDate && $booking->scheduleDate->schedule && $booking->scheduleDate->schedule->route)
                                            {{ $booking->scheduleDate->schedule->route->origin->name }} → {{ $booking->scheduleDate->schedule->route->destination->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-sm text-slate-600">
                                        @if($booking->scheduleDate)
                                            {{ $booking->scheduleDate->departure_date->format('d M Y') }}
                                        @else
                                            N/A
                                        @endif
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
                                            @else bg-primary/10 text-primary
                                            @endif">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary hover:text-primary-dark text-sm font-medium">View</a>
                                        @if($booking->booking_status !== 'cancelled')
                                        <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline ml-2"
                                            onsubmit="return confirm('Cancel booking #{{ $booking->booking_number }}?{{ $booking->payment_status === 'paid' ? ' This booking is PAID.' : '' }}')">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Cancel</button>
                                        </form>
                                        @endif
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
                                    No {{ $status }} bookings. <a href="{{ route('admin.bookings.index') }}" class="text-primary hover:text-primary-dark">View all bookings</a>
                                @else
                                    There are no bookings in the system yet.
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
