

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl py-8">
        <!-- Back Link & Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="<?php echo e(route('bookings.show', $booking)); ?>" class="w-9 h-9 bg-white border border-slate-200 rounded-md flex items-center justify-center text-slate-500 hover:text-primary hover:border-primary transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Track Your Bus</h1>
        </div>

        <!-- Booking Info Bar -->
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-4 mb-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Booking</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">#<?php echo e($booking->booking_number); ?></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Route</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">
                        <?php echo e($booking->scheduleDate->schedule->route->origin->name); ?> → <?php echo e($booking->scheduleDate->schedule->route->destination->name); ?>

                    </p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Date</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5"><?php echo e($booking->scheduleDate->departure_date->format('d M Y')); ?></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Bus</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5"><?php echo e($booking->scheduleDate->schedule->bus->registration_number); ?></p>
                </div>
            </div>
        </div>

        <?php if($booking->scheduleDate->driverAssignment && $booking->scheduleDate->driverAssignment->status === 'active'): ?>
            <!-- Live Tracking -->
            <div class="bg-white border border-slate-100 rounded-md shadow-sm mb-6">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-900 flex items-center">
                        <i class="fas fa-map-marked-alt mr-2 text-primary text-xs"></i> Live Bus Location
                    </h2>
                    <div id="tracking-status" class="flex items-center">
                        <span class="h-2.5 w-2.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-xs font-medium text-emerald-600">Live tracking</span>
                    </div>
                </div>

                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

                <div id="tracking-map" class="w-full" style="height: 400px;"></div>

                <div class="px-5 py-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Bus Location</p>
                        <p id="bus-location" class="text-sm font-medium text-slate-900 mt-0.5"><?php echo e($location ? ($location->location_name ? 'Near ' . $location->location_name : 'Lat: ' . $location->latitude . ', Lng: ' . $location->longitude) : 'Waiting for update...'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Speed</p>
                        <p id="bus-speed" class="text-sm font-medium text-slate-900 mt-0.5"><?php echo e($location && $location->speed ? $location->speed . ' km/h' : '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Last Updated</p>
                        <p id="last-updated" class="text-sm font-medium text-slate-900 mt-0.5"><?php echo e($location ? $location->recorded_at->diffForHumans() : '-'); ?></p>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scheduleDateId = <?php echo e($booking->schedule_date_id); ?>;

                let lat = <?php echo e($location ? $location->latitude : 7.8731); ?>;
                let lng = <?php echo e($location ? $location->longitude : 80.7718); ?>;
                let hasLocation = <?php echo e($location ? 'true' : 'false'); ?>;

                const map = L.map('tracking-map').setView([lat, lng], hasLocation ? 14 : 8);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const busIcon = L.divIcon({
                    html: '<div style="background: #4f46e5; color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 16px; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"><i class="fas fa-bus"></i></div>',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16],
                    className: '',
                });

                let marker = null;
                let firstUpdate = !hasLocation;
                if (hasLocation) {
                    marker = L.marker([lat, lng], { icon: busIcon }).addTo(map).bindPopup('Bus is here');
                }

                function updateMap(newLat, newLng, locationName, speed, recordedAt) {
                    if (marker) {
                        marker.setLatLng([newLat, newLng]);
                    } else {
                        marker = L.marker([newLat, newLng], { icon: busIcon }).addTo(map).bindPopup('Bus is here');
                    }
                    if (firstUpdate) {
                        map.setView([newLat, newLng], 14);
                        firstUpdate = false;
                    }

                    document.getElementById('bus-location').textContent = locationName ? 'Near ' + locationName : 'Lat: ' + parseFloat(newLat).toFixed(4) + ', Lng: ' + parseFloat(newLng).toFixed(4);
                    document.getElementById('bus-speed').textContent = speed ? speed + ' km/h' : '-';
                    document.getElementById('last-updated').textContent = 'Just now';
                }

                window.Echo.channel('tracking.' + scheduleDateId)
                    .listen('.location.updated', (data) => {
                        updateMap(data.latitude, data.longitude, data.locationName, data.speed, data.recordedAt);
                    });
            });
            </script>
        <?php elseif($booking->scheduleDate->driverAssignment): ?>
            <!-- Driver Assigned but Trip Not Started -->
            <div class="bg-white border border-slate-100 rounded-md shadow-sm p-12 text-center">
                <div class="w-14 h-14 bg-amber-50 rounded-md flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-amber-500 text-xl"></i>
                </div>
                <h3 class="text-sm font-medium text-slate-900">Trip hasn't started yet</h3>
                <p class="text-xs text-slate-500 mt-1">Live tracking will be available once the driver starts the trip.</p>
                <p class="text-xs text-slate-400 mt-3">
                    <i class="fas fa-user mr-1"></i> Driver: <?php echo e($booking->scheduleDate->driverAssignment->driver->user->name); ?>

                </p>
            </div>
        <?php else: ?>
            <!-- No Driver Assigned -->
            <div class="bg-white border border-slate-100 rounded-md shadow-sm p-12 text-center">
                <div class="w-14 h-14 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-slate-400 text-xl"></i>
                </div>
                <h3 class="text-sm font-medium text-slate-900">No driver assigned yet</h3>
                <p class="text-xs text-slate-500 mt-1">Live tracking will be available once a driver is assigned and starts the trip.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/tracking/show.blade.php ENDPATH**/ ?>