@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.provider-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Manage Schedule Dates</h1>
                    <p class="text-sm text-slate-500 mt-1">Add and manage dates for your schedules</p>
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

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm font-medium text-red-700 mb-1">Please fix the following errors:</p>
                        <ul class="list-disc ml-5 text-xs text-red-600">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Add Schedule Dates Form -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6 mb-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Add Schedule Dates</h2>

                    <form action="{{ route('provider.schedules.dates.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="schedule_id" class="block text-sm font-medium text-slate-700 mb-1">Select Schedule</label>
                                <select name="schedule_id" id="schedule_id"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" required>
                                    <option value="">Choose a schedule</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }} |
                                            {{ date('h:i A', strtotime($schedule->departure_time)) }} -
                                            {{ date('h:i A', strtotime($schedule->arrival_time)) }} |
                                            Bus: {{ $schedule->bus->registration_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('schedule_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Select Dates</label>
                                <div class="flex gap-2">
                                    <button type="button" id="single-date-btn" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md transition-colors">
                                        Single Dates
                                    </button>
                                    <button type="button" id="date-range-btn" class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                                        Date Range
                                    </button>
                                </div>
                            </div>

                            <!-- Single dates selection -->
                            <div id="single-dates-container" class="md:col-span-2">
                                <div class="flex flex-wrap gap-2 mb-2" id="selected-dates-display"></div>
                                <div class="flex gap-2">
                                    <input type="date" id="date-picker" min="{{ date('Y-m-d') }}"
                                        class="flex-1 px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                    <button type="button" id="add-date-btn" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                                        Add Date
                                    </button>
                                </div>
                                <div id="selected-dates-container">
                                    <!-- Hidden inputs for selected dates will be added here -->
                                </div>
                            </div>

                            <!-- Date range selection (initially hidden) -->
                            <div id="date-range-container" class="md:col-span-2 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="start-date" class="block text-xs text-slate-600 mb-1">Start Date</label>
                                        <input type="date" id="start-date" min="{{ date('Y-m-d') }}"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                    </div>
                                    <div>
                                        <label for="end-date" class="block text-xs text-slate-600 mb-1">End Date</label>
                                        <input type="date" id="end-date" min="{{ date('Y-m-d') }}"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <input id="weekdays-only" name="weekdays_only" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded">
                                        <label for="weekdays-only" class="ml-2 text-sm font-medium text-slate-700">Weekdays only</label>
                                    </div>

                                    <div class="mt-3">
                                        <span class="text-xs font-medium text-slate-600">Select days of week:</span>
                                        <div class="mt-2 flex flex-wrap gap-3">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="1" checked>
                                                <span class="ml-2 text-sm text-slate-600">Mon</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="2" checked>
                                                <span class="ml-2 text-sm text-slate-600">Tue</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="3" checked>
                                                <span class="ml-2 text-sm text-slate-600">Wed</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="4" checked>
                                                <span class="ml-2 text-sm text-slate-600">Thu</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="5" checked>
                                                <span class="ml-2 text-sm text-slate-600">Fri</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="6" checked>
                                                <span class="ml-2 text-sm text-slate-600">Sat</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="weekday-checkbox h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded" value="0" checked>
                                                <span class="ml-2 text-sm text-slate-600">Sun</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="generate-dates-btn" class="mt-4 px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                                    Generate Dates
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <p id="dates-count" class="text-xs text-slate-500">No dates selected</p>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                                Save Schedule Dates
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Existing Schedule Dates -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-900">Existing Schedule Dates</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Schedule</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Date</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Available Seats</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="schedule-dates-table" class="divide-y divide-slate-50">
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">
                                        Select a schedule to view its dates
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/50 transition-opacity" onclick="closeEditModal()"></div>
        <div class="relative bg-white rounded-md shadow-lg max-w-sm w-full p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Edit Schedule Date Status</h3>
            <form id="editForm">
                @csrf
                <input type="hidden" id="editScheduleDateId" name="id">
                <div class="mb-4">
                    <label for="editStatus" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select id="editStatus" name="status"
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                        <option value="scheduled">Scheduled</option>
                        <option value="departed">Departed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleSelect = document.getElementById('schedule_id');
        if (scheduleSelect) {
            scheduleSelect.value = '';
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle between single dates and date range
    const singleDateBtn = document.getElementById('single-date-btn');
    const dateRangeBtn = document.getElementById('date-range-btn');
    const singleDatesContainer = document.getElementById('single-dates-container');
    const dateRangeContainer = document.getElementById('date-range-container');

    singleDateBtn.addEventListener('click', function() {
        singleDatesContainer.classList.remove('hidden');
        dateRangeContainer.classList.add('hidden');
        singleDateBtn.classList.remove('border', 'border-slate-200', 'text-slate-700', 'bg-white');
        singleDateBtn.classList.add('bg-primary', 'text-white');
        dateRangeBtn.classList.remove('bg-primary', 'text-white');
        dateRangeBtn.classList.add('border', 'border-slate-200', 'text-slate-700', 'bg-white');
    });

    dateRangeBtn.addEventListener('click', function() {
        singleDatesContainer.classList.add('hidden');
        dateRangeContainer.classList.remove('hidden');
        dateRangeBtn.classList.remove('border', 'border-slate-200', 'text-slate-700', 'bg-white');
        dateRangeBtn.classList.add('bg-primary', 'text-white');
        singleDateBtn.classList.remove('bg-primary', 'text-white');
        singleDateBtn.classList.add('border', 'border-slate-200', 'text-slate-700', 'bg-white');
    });

    // Logic for adding single dates
    const datePicker = document.getElementById('date-picker');
    const addDateBtn = document.getElementById('add-date-btn');
    const selectedDatesDisplay = document.getElementById('selected-dates-display');
    const selectedDatesContainer = document.getElementById('selected-dates-container');
    const selectedDates = new Set();
    const datesCountEl = document.getElementById('dates-count');

    function updateDatesCount() {
        const count = selectedDates.size;
        datesCountEl.textContent = count > 0 ? count + ' date(s) selected' : 'No dates selected';
        datesCountEl.className = count > 0 ? 'text-xs text-emerald-600 font-medium' : 'text-xs text-slate-500';
    }

    addDateBtn.addEventListener('click', function() {
        const selectedDate = datePicker.value;
        if (!selectedDate) { alert('Please select a date'); return; }
        if (selectedDates.has(selectedDate)) { alert('This date is already selected'); return; }

        selectedDates.add(selectedDate);

        const dateTag = document.createElement('div');
        dateTag.className = 'bg-primary/10 text-primary rounded-md px-3 py-1 text-xs font-medium flex items-center';
        const formattedDate = new Date(selectedDate).toLocaleDateString();
        dateTag.innerHTML = `${formattedDate}<button type="button" class="ml-2 text-primary hover:text-primary-dark" data-date="${selectedDate}">&times;</button>`;
        selectedDatesDisplay.appendChild(dateTag);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'dates[]';
        hiddenInput.value = selectedDate;
        hiddenInput.id = `date-input-${selectedDate}`;
        selectedDatesContainer.appendChild(hiddenInput);

        datePicker.value = '';
        updateDatesCount();

        dateTag.querySelector('button').addEventListener('click', function() {
            const dateToRemove = this.getAttribute('data-date');
            selectedDates.delete(dateToRemove);
            dateTag.remove();
            document.getElementById(`date-input-${dateToRemove}`).remove();
            updateDatesCount();
        });
    });

    let isDateRangeMode = false;
    singleDateBtn.addEventListener('click', function() { isDateRangeMode = false; });
    dateRangeBtn.addEventListener('click', function() { isDateRangeMode = true; });

    selectedDatesContainer.closest('form').addEventListener('submit', function(e) {
        if (isDateRangeMode) { generateDatesBtn.click(); }
        const hiddenInputs = selectedDatesContainer.querySelectorAll('input[name="dates[]"]');
        if (hiddenInputs.length === 0) {
            e.preventDefault();
            alert('Please add at least one date before saving.');
        }
    });

    // Logic for generating dates from range
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const weekdaysOnlyCheckbox = document.getElementById('weekdays-only');
    const weekdayCheckboxes = document.querySelectorAll('.weekday-checkbox');
    const generateDatesBtn = document.getElementById('generate-dates-btn');

    weekdaysOnlyCheckbox.addEventListener('change', function() {
        if (this.checked) {
            weekdayCheckboxes.forEach(checkbox => {
                checkbox.checked = !(checkbox.value == '0' || checkbox.value == '6');
            });
        } else {
            weekdayCheckboxes.forEach(checkbox => { checkbox.checked = true; });
        }
    });

    generateDatesBtn.addEventListener('click', function() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        if (!startDate || !endDate) { alert('Please select both start and end dates'); return; }
        if (new Date(startDate) > new Date(endDate)) { alert('End date must be after start date'); return; }

        const selectedDaysOfWeek = [];
        weekdayCheckboxes.forEach(checkbox => {
            if (checkbox.checked) selectedDaysOfWeek.push(parseInt(checkbox.value));
        });
        if (selectedDaysOfWeek.length === 0) { alert('Please select at least one day of the week'); return; }

        let currentDate = new Date(startDate);
        const end = new Date(endDate);

        while (currentDate <= end) {
            const dayOfWeek = currentDate.getDay();
            if (selectedDaysOfWeek.includes(dayOfWeek)) {
                const dateString = currentDate.toISOString().split('T')[0];
                if (!selectedDates.has(dateString)) {
                    selectedDates.add(dateString);
                    const dateTag = document.createElement('div');
                    dateTag.className = 'bg-primary/10 text-primary rounded-md px-3 py-1 text-xs font-medium flex items-center';
                    const formattedDate = currentDate.toLocaleDateString();
                    dateTag.innerHTML = `${formattedDate}<button type="button" class="ml-2 text-primary hover:text-primary-dark" data-date="${dateString}">&times;</button>`;
                    selectedDatesDisplay.appendChild(dateTag);

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'dates[]';
                    hiddenInput.value = dateString;
                    hiddenInput.id = `date-input-${dateString}`;
                    selectedDatesContainer.appendChild(hiddenInput);

                    dateTag.querySelector('button').addEventListener('click', function() {
                        const dateToRemove = this.getAttribute('data-date');
                        selectedDates.delete(dateToRemove);
                        dateTag.remove();
                        document.getElementById(`date-input-${dateToRemove}`).remove();
                        updateDatesCount();
                    });
                }
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
        updateDatesCount();
        singleDateBtn.click();
    });

    // Load schedule dates when a schedule is selected
    const scheduleSelect = document.getElementById('schedule_id');
    const scheduleDatesTable = document.getElementById('schedule-dates-table');

    scheduleSelect.addEventListener('change', function() {
        const scheduleId = this.value;
        if (!scheduleId) {
            scheduleDatesTable.innerHTML = `<tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">Select a schedule to view its dates</td></tr>`;
            return;
        }

        scheduleDatesTable.innerHTML = `<tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading schedule dates...</td></tr>`;

        setTimeout(() => { fetchScheduleDates(scheduleId); }, 500);
    });

    function fetchScheduleDates(scheduleId) {
        fetch(`/provider/schedules/${scheduleId}/dates`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    scheduleDatesTable.innerHTML = `<tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No dates found for this schedule.</td></tr>`;
                    return;
                }

                let html = '';
                data.forEach(date => {
                    const statusClass = date.status === 'scheduled' ? 'bg-emerald-50 text-emerald-700' : date.status === 'cancelled' ? 'bg-red-50 text-red-700' : date.status === 'departed' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-600';
                    html += `
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-5 py-3 text-sm text-slate-900">${date.schedule_info}</td>
                            <td class="px-5 py-3 text-sm text-slate-600">${new Date(date.date).toLocaleDateString()}</td>
                            <td class="px-5 py-3 text-sm text-slate-600">${date.available_seats} / ${date.total_seats}</td>
                            <td class="px-5 py-3"><span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md ${statusClass}">${date.status}</span></td>
                            <td class="px-5 py-3">
                                <button type="button" class="text-primary hover:text-primary-dark text-sm mr-3" onclick="openEditModal(${date.id}, '${date.status}')">Edit</button>
                                <button type="button" class="text-red-500 hover:text-red-700 text-sm" onclick="deleteScheduleDate(${date.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                scheduleDatesTable.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching schedule dates:', error);
                scheduleDatesTable.innerHTML = `<tr><td colspan="5" class="px-5 py-8 text-center text-sm text-red-500">Error loading schedule dates. Please try again.</td></tr>`;
            });
    }
});

function deleteScheduleDate(dateId) {
    if (confirm('Are you sure you want to delete this schedule date? This cannot be undone.')) {
        fetch(`/provider/schedules/dates/${dateId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) { alert(data.error); return; }
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the schedule date');
        });
    }
}

function openEditModal(dateId, currentStatus) {
    document.getElementById('editScheduleDateId').value = dateId;
    document.getElementById('editStatus').value = currentStatus;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const dateId = document.getElementById('editScheduleDateId').value;
    const status = document.getElementById('editStatus').value;

    fetch(`/provider/schedules/dates/${dateId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            window.location.reload();
        } else {
            alert(data.error || 'Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the status');
    });
});
</script>
@endsection
