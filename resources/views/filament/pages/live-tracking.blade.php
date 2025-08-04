<x-filament::page>
    <h2 class="text-lg font-semibold mb-4 text-black">Live Tracking Kendaraan</h2>

    <style>
        #map {
            width: 600px;
            height: 600px;
            min-height: 300px;
            border-radius: 8px;
        }
        .max-w-md {
            max-width: 100%;
            margin: 0 auto;
        }
    </style>

    <div class="rounded-lg border shadow p-4 bg-white max-w-md">
        <div id="map"></div>
    </div>

    {{-- Include Leaflet CSS & JS --}}
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

    {{-- Include Pusher --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const initialLocations = @json($locations);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('map').setView([-0.056170, 109.310976], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            const locationMarkers = {};

            // Inisialisasi marker awal dari database
            initialLocations.forEach(loc => {
                const { user_id, latitude, longitude } = loc;
                const marker = L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup(`User ID: ${user_id}`);
                locationMarkers[user_id] = marker;
            });

            setTimeout(() => map.invalidateSize(), 20);
            window.addEventListener('resize', () => map.invalidateSize());

            const pusher = new Pusher('50678e8196ba007f9922', {
                cluster: 'ap1',
                forceTLS: true,
            });

            const channel = pusher.subscribe('vehicle-tracking');

            channel.bind('location.updated', data => {
                const { user_id, lat, lng } = data;

                if (locationMarkers[user_id]) {
                    locationMarkers[user_id].setLatLng([lat, lng]);
                    locationMarkers[user_id].getPopup().setContent(`User ID: ${user_id}`);
                } else {
                    const marker = L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup(`User ID: ${user_id}`);
                    locationMarkers[user_id] = marker;
                }

                map.panTo([lat, lng]);
            });
        });
    </script>
</x-filament::page>
