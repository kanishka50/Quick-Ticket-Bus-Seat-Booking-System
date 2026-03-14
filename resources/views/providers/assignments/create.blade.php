@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.provider-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="{{ route('provider.assignments.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Assign Driver to Trip</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Assign a driver to a scheduled trip date</p>
                </div>

                @if($drivers->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6">
                    <p class="text-sm text-amber-800">No active drivers available. <a href="{{ route('provider.drivers.create') }}" class="font-medium text-primary hover:text-primary-dark underline">Add a driver first</a>.</p>
                </div>
                @endif

                @if($schedules->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6">
                    <p class="text-sm text-amber-800">No active schedules available.</p>
                </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="{{ route('provider.assignments.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="driver_id" class="block text-sm font-medium text-slate-700 mb-1">Driver</label>
                                <select name="driver_id" id="driver_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->user->name }} ({{ $driver->license_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('driver_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="schedule_id" class="block text-sm font-medium text-slate-700 mb-1">Schedule</label>
                                <select id="schedule_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Schedule</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}">
                                            {{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }} | {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A') }} | Bus: {{ $schedule->bus->registration_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="schedule_date_id" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                                <select name="schedule_date_id" id="schedule_date_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required disabled>
                                    <option value="">Select a schedule first</option>
                                </select>
                                <p id="dates-loading" class="text-xs text-slate-400 mt-1 hidden">Loading available dates...</p>
                                @error('schedule_date_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('provider.assignments.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Assign Driver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleSelect = document.getElementById('schedule_id');
    const dateSelect = document.getElementById('schedule_date_id');
    const loadingText = document.getElementById('dates-loading');

    scheduleSelect.addEventListener('change', function() {
        const scheduleId = this.value;

        dateSelect.innerHTML = '<option value="">Loading...</option>';
        dateSelect.disabled = true;

        if (!scheduleId) {
            dateSelect.innerHTML = '<option value="">Select a schedule first</option>';
            return;
        }

        loadingText.classList.remove('hidden');

        fetch(`/provider/assignments/schedule-dates/${scheduleId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(res => res.json())
        .then(dates => {
            loadingText.classList.add('hidden');

            if (dates.length === 0) {
                dateSelect.innerHTML = '<option value="">No unassigned dates available</option>';
                dateSelect.disabled = true;
                return;
            }

            let html = '<option value="">Select Date</option>';
            dates.forEach(d => {
                html += `<option value="${d.id}">${d.date} (${d.available_seats} seats available)</option>`;
            });
            dateSelect.innerHTML = html;
            dateSelect.disabled = false;
        })
        .catch(() => {
            loadingText.classList.add('hidden');
            dateSelect.innerHTML = '<option value="">Error loading dates</option>';
        });
    });
});
</script>
@endsection
