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
                        <a href="{{ route('provider.buses.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Add New Bus</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Add a new bus to your fleet</p>
                </div>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="{{ route('provider.buses.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="registration_number" class="block text-sm font-medium text-slate-700 mb-1">Registration Number</label>
                                <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" required>
                                @error('registration_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Bus Name (Optional)</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bus_type_id" class="block text-sm font-medium text-slate-700 mb-1">Bus Type</label>
                                <select name="bus_type_id" id="bus_type_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Select Bus Type</option>
                                    @foreach($busTypes as $busType)
                                        <option value="{{ $busType->id }}" {{ old('bus_type_id') == $busType->id ? 'selected' : '' }}>
                                            {{ $busType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bus_type_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Total Seats</label>
                                <p id="total-seats-display" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-md text-sm text-slate-600">0 (generate layout below)</p>
                                <p class="text-xs text-slate-500 mt-1">Auto-calculated from seat layout. Click seats to disable/enable them.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-3">Seat Layout</label>
                                <div id="seat-layout-builder" class="border border-slate-200 rounded-md p-4 bg-slate-50">
                                    <div class="flex justify-between mb-4">
                                        <div>
                                            <label for="rows" class="block text-xs text-slate-600 mb-1">Rows</label>
                                            <input type="number" id="rows" min="1" max="20" value="10"
                                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                        </div>
                                        <div>
                                            <label for="columns" class="block text-xs text-slate-600 mb-1">Columns</label>
                                            <input type="number" id="columns" min="1" max="6" value="4"
                                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                        </div>
                                        <div class="pt-5">
                                            <button type="button" id="generate-layout" class="py-2 px-4 bg-primary text-white text-sm rounded-md hover:bg-primary-dark transition-colors">Generate</button>
                                        </div>
                                    </div>
                                    <div id="seat-grid" class="mb-4 grid grid-cols-4 gap-2">
                                        <!-- Seats will be generated here -->
                                    </div>
                                    <input type="hidden" name="seat_layout" id="seat-layout-json" value="{{ old('seat_layout', '[]') }}">
                                </div>
                                @error('seat_layout')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-3">Amenities</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="AC">
                                        <span class="ml-2 text-sm text-slate-600">Air Conditioning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="WiFi">
                                        <span class="ml-2 text-sm text-slate-600">WiFi</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="USB">
                                        <span class="ml-2 text-sm text-slate-600">USB Charging</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="TV">
                                        <span class="ml-2 text-sm text-slate-600">TV</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Toilet">
                                        <span class="ml-2 text-sm text-slate-600">Toilet</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Blanket">
                                        <span class="ml-2 text-sm text-slate-600">Blanket</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Reclining">
                                        <span class="ml-2 text-sm text-slate-600">Reclining Seats</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="amenity-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="Water">
                                        <span class="ml-2 text-sm text-slate-600">Water Bottle</span>
                                    </label>
                                </div>
                                <input type="hidden" name="amenities" id="amenities-json" value="{{ old('amenities', '[]') }}">
                                @error('amenities')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('provider.buses.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Save Bus
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
    const generateLayout = document.getElementById('generate-layout');
    generateLayout.addEventListener('click', function() {
        const rows = parseInt(document.getElementById('rows').value) || 10;
        const columns = parseInt(document.getElementById('columns').value) || 4;

        if (rows > 20 || columns > 6) {
            alert('Maximum rows: 20, Maximum columns: 6');
            return;
        }

        const seatGrid = document.getElementById('seat-grid');
        seatGrid.innerHTML = '';
        seatGrid.style.gridTemplateColumns = `repeat(${columns}, minmax(0, 1fr))`;

        let seatNumber = 1;
        const seatLayout = [];

        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                const seat = document.createElement('div');
                const seatId = `seat-${i}-${j}`;
                const seatDisplay = String.fromCharCode(65 + i) + (j + 1);

                seat.id = seatId;
                seat.className = 'seat bg-primary/10 text-primary text-center py-2 rounded-md cursor-pointer hover:bg-primary/20 text-sm font-medium';
                seat.textContent = seatDisplay;
                seat.dataset.row = i;
                seat.dataset.column = j;
                seat.dataset.number = seatNumber++;

                seat.addEventListener('click', function() {
                    if (this.classList.contains('bg-slate-200')) {
                        this.classList.remove('bg-slate-200', 'text-slate-400');
                        this.classList.add('bg-primary/10', 'text-primary');
                    } else {
                        this.classList.remove('bg-primary/10', 'text-primary');
                        this.classList.add('bg-slate-200', 'text-slate-400');
                    }
                    updateSeatLayout();
                });

                seatGrid.appendChild(seat);

                seatLayout.push({
                    id: seatId,
                    number: seatDisplay,
                    row: i,
                    column: j,
                    status: 'available'
                });
            }
        }

        document.getElementById('seat-layout-json').value = JSON.stringify(seatLayout);
        updateSeatCount();
    });

    generateLayout.click();

    function updateSeatLayout() {
        const seats = document.querySelectorAll('#seat-grid .seat');
        const seatLayout = [];

        seats.forEach(seat => {
            seatLayout.push({
                id: seat.id,
                number: seat.textContent,
                row: parseInt(seat.dataset.row),
                column: parseInt(seat.dataset.column),
                status: seat.classList.contains('bg-slate-200') ? 'disabled' : 'available'
            });
        });

        document.getElementById('seat-layout-json').value = JSON.stringify(seatLayout);
        updateSeatCount();
    }

    function updateSeatCount() {
        const seats = document.querySelectorAll('#seat-grid .seat');
        let available = 0;
        let disabled = 0;
        seats.forEach(seat => {
            if (seat.classList.contains('bg-slate-200')) {
                disabled++;
            } else {
                available++;
            }
        });
        const display = document.getElementById('total-seats-display');
        if (disabled > 0) {
            display.textContent = `${available} available seats (${disabled} disabled)`;
        } else {
            display.textContent = `${available} seats`;
        }
    }

    const amenityCheckboxes = document.querySelectorAll('.amenity-checkbox');
    amenityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateAmenities);
    });

    function updateAmenities() {
        const amenities = [];
        document.querySelectorAll('.amenity-checkbox:checked').forEach(checkbox => {
            amenities.push(checkbox.value);
        });
        document.getElementById('amenities-json').value = JSON.stringify(amenities);
    }

    updateAmenities();
});
</script>
@endsection
