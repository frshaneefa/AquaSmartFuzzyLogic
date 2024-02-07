@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>  
    
<style>
    /* Add a keyframe animation for fade slide-in effect */
    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Apply the animation to the specified element */
    .fade-slide-in {
        animation: fadeSlideIn 0.5s ease-in-out;
    }

    /* Additional styling for centering the text */
    .text-center {
        text-align: center;
    }

    .mb-4 {
        margin-bottom: 4px;
    }
        
    #map-container {
        border-radius: 10px;
        width: 95%;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px auto; /* Add margin to create space between map and form card */
    }

    #map {
        width: 100%;
        height: 500px;
    }
</style>

<h1 class="text-center mb-4 fade-slide-in">PLEASE CHOOSE WATER PUMP BELOW:</h1>

<div id="map-container" class="card fade-slide-in">
    <div id="map"></div>
</div>

<script>
    var map = L.map('map').setView([3.517756, 103.398920], 18);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    function updateMonitoringStatus(pumpName) {
        var monitoringStatus = "Monitoring " + pumpName;

        // Add the monitoring status to the URL
        var monitoringStatusParam = encodeURIComponent(monitoringStatus);
        window.location.href = "http://192.168.0.153:8000/dashboard?status=" + monitoringStatusParam;
    }

    // Add the first marker to the map with a popup
    var marker1 = L.marker([3.517756, 103.398920]).addTo(map)
        .bindPopup('<b>PUMP 1:</b><br>Offline<br><a href="#" onclick="updateMonitoringStatus(\'PUMP 1\');">Go to Dashboard</a>'); // Add your popup content

    // Add the second marker to the map with a popup
    var marker2 = L.marker([3.518045, 103.399102]).addTo(map)
        .bindPopup('<b>PUMP 2:</b><br>Online<br><a href="#" onclick="updateMonitoringStatus(\'PUMP 2\');">Go to Dashboard</a>'); // Add your popup content

    // Add the third marker to the map with a popup
    var marker3 = L.marker([3.517681, 103.398796]).addTo(map)
        .bindPopup('<b>PUMP 3:</b><br>Offline<br><a href="#" onclick="updateMonitoringStatus(\'PUMP 3\');">Go to Dashboard</a>'); // Add your popup content

    // Open the popups by default
    // marker1.openPopup();
    marker2.openPopup();
    // marker3.openPopup();
</script>
@endsection
