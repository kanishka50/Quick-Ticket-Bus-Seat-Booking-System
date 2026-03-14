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
                        <a href="{{ route('provider.schedules.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Create New Schedule</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Set up a new bus schedule for your routes</p>
                </div>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="{{ route('provider.schedules.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="route_id" class="block text-sm font-medium text-slate-700 mb-1">Route</label>
                                <select name="route_id" id="route_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Route</option>
                                    @foreach($routes as $route)
                                        <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                            {{ $route->origin->name }} → {{ $route->destination->name }} ({{ $route->distance }} km)
                                        </option>
                                    @endforeach
                                </select>
                                @error('route_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bus_id" class="block text-sm font-medium text-slate-700 mb-1">Bus</label>
                                <select name="bus_id" id="bus_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Bus</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                            {{ $bus->registration_number }} {{ $bus->name ? '- '.$bus->name : '' }} ({{ $bus->busType->name }}, {{ $bus->total_seats }} seats)
                                        </option>
                                    @endforeach
                                </select>
                                @error('bus_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="departure_time" class="block text-sm font-medium text-slate-700 mb-1">Departure Time</label>
                                <input type="time" name="departure_time" id="departure_time" value="{{ old('departure_time') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                @error('departure_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="arrival_time" class="block text-sm font-medium text-slate-700 mb-1">Arrival Time</label>
                                <input type="time" name="arrival_time" id="arrival_time" value="{{ old('arrival_time') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                @error('arrival_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Ticket Price (LKR)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm">LKR</span>
                                    </div>
                                    <input type="number" name="price" id="price" min="0.01" step="0.01" value="{{ old('price') }}"
                                        class="w-full pl-12 pr-4 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('provider.schedules.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Save Schedule
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mt-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-3">Schedule Availability</h2>
                    <p class="text-xs text-slate-500 mb-3">Once you have created the schedule, you'll need to add specific departure dates on which this schedule will operate.</p>

                    <div class="border border-primary/20 bg-primary/5 rounded-md p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-xs font-medium text-primary">Next Step: Add Schedule Dates</h3>
                                <p class="text-xs text-slate-600 mt-1">After creating this schedule, go to "Manage Schedule Dates" to specify which dates this schedule will be available for booking.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departureTimeInput = document.getElementById('departure_time');
    const arrivalTimeInput = document.getElementById('arrival_time');

    function checkOvernight() {
        const departure = departureTimeInput.value;
        const arrival = arrivalTimeInput.value;
        let note = document.getElementById('overnight-note');

        if (departure && arrival && arrival <= departure) {
            if (!note) {
                note = document.createElement('p');
                note.id = 'overnight-note';
                note.className = 'text-xs text-amber-600 mt-1';
                note.textContent = 'Arrival is next day (overnight schedule)';
                arrivalTimeInput.parentNode.appendChild(note);
            }
        } else if (note) {
            note.remove();
        }
    }

    departureTimeInput.addEventListener('change', checkOvernight);
    arrivalTimeInput.addEventListener('change', checkOvernight);
});
</script>
@endsection
