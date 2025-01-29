@extends('layouts.main')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        #map {
            height: 300px;
            width: auto;
        }
    </style>
@endsection
@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header">Kontakt</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <p><b>Adres:</b></p>
                <p>Konstantego Ciołkowskiego 1<br>15-245 Białystok</p>
                <p><b>Numer telefonu:</b></p>
                <p><a href="tel:+48888888888">+48 888 888 888</a></p>
                <p><b>Adres e-mail:</b></p>
                <p><a href="mailto:warsztat@samochodowy.pl">warsztat@samochodowy.pl</a></p>
            </div>
            <div class="col-4">
                <div id="map"></div>
            </div>
        </div>    
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentTheme = localStorage.getItem('theme') || 'light';
    
            var map = L.map('map').setView([53.108378, 23.154328], 13);
    
            var lightLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });
    
            var darkLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            });
    
            function updateMapTheme(theme) {
                if (theme === 'dark') {
                    map.removeLayer(lightLayer);
                    map.addLayer(darkLayer);
                } else {
                    map.removeLayer(darkLayer);
                    map.addLayer(lightLayer);
                }
            }
    
            if (currentTheme === 'dark') {
                darkLayer.addTo(map);
            } else {
                lightLayer.addTo(map);
            }
    
            var marker = L.marker([53.108378, 23.154328]).addTo(map)
                .bindPopup("<b>Siedziba naszej firmy</b><br>Konstantego Ciołkowskiego 1<br>15-245 Białystok")
                .openPopup();
    
            const toggle = document.getElementById('toggle-dark-mode');
            if (toggle) {
                toggle.addEventListener('change', function () {
                    let newTheme = this.checked ? 'dark' : 'light';
                    updateMapTheme(newTheme);
                });
            }
        });
    </script>
    
    
@endsection