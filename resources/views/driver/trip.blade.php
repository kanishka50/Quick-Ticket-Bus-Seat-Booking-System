@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.driver-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('driver.dashboard') }}" class="text-slate-400 hover:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <h1 class="text-xl font-bold text-slate-900">Active Trip</h1>
                        </div>
                        <form action="{{ route('driver.trip.end', $assignment) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors"
                                onclick="return confirm('End this trip? Location sharing will stop.')">
                                End Trip
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Trip Details -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5 mb-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-100">Trip Details</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Route</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $assignment->scheduleDate->schedule->route->origin->name }} → {{ $assignment->scheduleDate->schedule->route->destination->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Bus</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $assignment->scheduleDate->schedule->bus->registration_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Departure</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ \Carbon\Carbon::parse($assignment->scheduleDate->schedule->departure_time)->format('h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Date</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $assignment->scheduleDate->departure_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Live Location -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-900">Live Location</h2>
                        <div id="tracking-status" class="flex items-center">
                            <span class="h-2.5 w-2.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-xs font-medium text-emerald-600">Sharing location</span>
                        </div>
                    </div>
                    <div id="driver-map" style="height: 300px; border-radius: 0.375rem;"></div>
                    <div class="mt-3">
                        <p id="location-text" class="text-sm text-slate-600">Getting location...</p>
                        <p id="speed-text" class="text-xs text-slate-400 mt-1"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignmentId = {{ $assignment->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Initialize Leaflet map centered on Sri Lanka
    const map = L.map('driver-map').setView([7.8731, 80.7718], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    let watchId = null;
    let firstUpdate = true;

    function updateMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
        // Only auto-center on first update, then let driver pan freely
        if (firstUpdate) {
            map.setView([lat, lng], 14);
            firstUpdate = false;
        }
    }

    function reverseGeocode(lat, lng, callback) {
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&zoom=14`)
            .then(res => res.json())
            .then(data => {
                const name = data.address ?
                    (data.address.suburb || data.address.town || data.address.city || data.address.county || '') +
                    (data.address.state ? ', ' + data.address.state : '') : '';
                callback(name || 'Unknown location');
            })
            .catch(() => callback(null));
    }

    function sendLocation(lat, lng, speed, locationName) {
        fetch('/driver/location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                latitude: lat,
                longitude: lng,
                speed: speed,
                location_name: locationName,
                assignment_id: assignmentId,
            })
        }).catch(err => console.error('Failed to send location:', err));
    }

    let lastSent = 0;
    const SEND_INTERVAL = 15000; // Send every 15 seconds

    function handlePosition(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        const speed = position.coords.speed ? (position.coords.speed * 3.6).toFixed(1) : null; // m/s to km/h

        // Reset status to green on successful location
        const statusEl = document.getElementById('tracking-status');
        statusEl.innerHTML = '<span class="h-2.5 w-2.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span><span class="text-xs font-medium text-emerald-600">Sharing location</span>';

        updateMarker(lat, lng);

        const now = Date.now();
        if (now - lastSent >= SEND_INTERVAL) {
            lastSent = now;
            reverseGeocode(lat, lng, function(locationName) {
                document.getElementById('location-text').textContent = locationName ? 'Near ' + locationName : 'Lat: ' + lat.toFixed(4) + ', Lng: ' + lng.toFixed(4);
                sendLocation(lat, lng, speed, locationName);
            });
        } else {
            document.getElementById('location-text').textContent = 'Lat: ' + lat.toFixed(4) + ', Lng: ' + lng.toFixed(4);
        }

        if (speed) {
            document.getElementById('speed-text').textContent = 'Speed: ' + speed + ' km/h';
        }
    }

    function handleError(error) {
        const statusEl = document.getElementById('tracking-status');
        statusEl.innerHTML = '<span class="h-2.5 w-2.5 bg-red-500 rounded-full mr-2"></span><span class="text-xs font-medium text-red-600">Location error</span>';
        document.getElementById('location-text').textContent = 'Error: ' + error.message + '. Please enable GPS.';
    }

    if (navigator.geolocation) {
        // Watch position continuously for smooth map updates
        watchId = navigator.geolocation.watchPosition(handlePosition, handleError, {
            enableHighAccuracy: true,
            maximumAge: 30000,
            timeout: 10000,
        });

        // Also send immediately on page load
        navigator.geolocation.getCurrentPosition(function(pos) {
            lastSent = Date.now();
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const speed = pos.coords.speed ? (pos.coords.speed * 3.6).toFixed(1) : null;

            updateMarker(lat, lng);
            reverseGeocode(lat, lng, function(locationName) {
                document.getElementById('location-text').textContent = locationName ? 'Near ' + locationName : 'Lat: ' + lat.toFixed(4) + ', Lng: ' + lng.toFixed(4);
                sendLocation(lat, lng, speed, locationName);
            });
        }, handleError, { enableHighAccuracy: true, timeout: 10000 });
    } else {
        document.getElementById('location-text').textContent = 'Geolocation is not supported by this browser.';
    }
});
</script>
@endsection
