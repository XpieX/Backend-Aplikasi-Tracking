<div id="map" style="height: 400px; border-radius: 8px;"></div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([-0.0263, 109.3425], 13); // koordinat default Singkawang

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            }).addTo(map);

            let marker;

            function updateLatLng(lat, lng) {
                const latInput = document.querySelector('input[name="data.latitude"]');
                const lngInput = document.querySelector('input[name="data.longitude"]');
                if (latInput && lngInput) {
                    latInput.value = lat.toFixed(8);
                    lngInput.value = lng.toFixed(8);
                    latInput.dispatchEvent(new Event('input')); // biar reactive
                    lngInput.dispatchEvent(new Event('input'));
                }
            }

            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                updateLatLng(lat, lng);
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
