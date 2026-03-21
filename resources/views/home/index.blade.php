@extends('layouts.app')

@section('title', 'Compare Rides - Save Money on Bolt, Uber, inDrive & Taxis in Accra')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Favicon -->
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚕</text></svg>">
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<div class="min-h-screen">
    <style>
        @keyframes fade-in {
       from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
     }

     .animate-fade-in {
    animation: fade-in 0.3s ease-out;
    }
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #16a34a;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
  </style>
    <!-- Hero Section -->
    <div class="text-white py-12" style="background: #39C70D;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                    Compare Rides. Save Money. 🚕
                </h1>
                <p class="text-xl text-green-100">
                    Get real-time prices from Bolt, Uber, inDrive & Taxis in Accra
                </p>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Panel - Location Inputs -->
            <div id="formContainer" class="lg:col-span-3 space-y-6">
               <div id="formInner" class="max-w-4xl mx-auto">
                <!-- Location Form -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Where to?</h2>
                    
                    <form class="space-y-4">
                        <!-- Pickup Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📍 Pickup Location
                            </label>
                            <input 
                                type="text"
                                id="pickupInput" 
                                placeholder="Enter pickup location"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                        </div>
                        
                        <!-- Dropoff Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                🎯 Dropoff Location
                            </label>
                            <input 
                                type="text" 
                                id="dropoffInput"
                                placeholder="Enter destination"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                        </div>
                        
                        <!-- Use Current Location Button -->
                        <button 
                            type="button"
                            id="currentLocationBtn"
                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Use Current Location</span>
                        </button>
                        
                        <!-- Compare Button -->
                        <button 
                            type="button"
                            id="compareBtn"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2"
                        >
                            <span>Compare Rides</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                        <!-- Recent Locations -->
                      <div id="recentLocations" class="hidden">
                     <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-1 mt-2">
                       Recent
                         </p>
                      <div id="recentList" class="space-y-1 mb-3"></div>
                     </div>
                         <!-- Clear Button -->
                        <button 
                         type="button"
                         id="clearBtn"
                         class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2"
                         >
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                         </svg>
                           <span>Clear</span>
                        </button>
                    </form>
                </div>
                
               <!-- Sample Results -->
 <div id="availableRides" class="space-y-3 hidden">
    <h3 class="text-lg font-bold text-gray-900">Available Rides</h3>
    <!-- Savings Summary Banner -->
 <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="text-3xl">💰</div>
            <div>
                <p class="text-sm font-medium">Best Deal Available</p>
                <p id="bestDealText" class="text-lg font-bold">Calculating...</p>
            </div>
        </div>
        <div class="text-right">
            <p id="savingPctText" class="text-2xl font-bold">--%</p>
            <p class="text-xs">vs most expensive</p>
        </div>
    </div>
 </div>
    <!-- inDrive -->
    <div id="indriveCard" class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition cursor-pointer border-2 border-green-500">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl">
                    🚙
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="font-bold text-gray-900">inDrive</h4>
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">CHEAPEST</span>
                    </div>
                    <p class="text-sm text-gray-600">Standard</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-green-600 price display">--</p>
                <p class="text-xs text-green-600 font-semibold saving-display"></p>
                <p class="text-xs text-gray-500 eta-display"></p>
            </div>
        </div>
    </div>
    
    <!-- Bolt -->
    <div id="boltCard" class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition cursor-pointer">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl">
                    ⚡
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Bolt</h4>
                    <p class="text-sm text-gray-600">Bolt Go</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-green-600 price display"></p>
                <p class="text-xs text-green-600 font-semibold saving-display"></p>
                <p class="text-xs text-gray-500 eta-display"></p>
            </div>
        </div>
    </div>
    
    <!-- Uber -->
    <div id="uberCard" class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition cursor-pointer">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center text-2xl">
                    🚗
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Uber</h4>
                    <p class="text-sm text-gray-600">UberX</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-green-600 price display"></p>
                <p class="text-xs text-green-600 font-semibold saving-display"></p>
                <p class="text-xs text-gray-500 eta-display"></p>
            </div>
        </div>
    </div>
    
    <!-- Taxi-->
    <div id="taxiCard" class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition cursor-pointer">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-2xl">
                    🚕
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Taxi</h4>
                    <p class="text-sm text-gray-600">Local Cab</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-green-600 price-display"></p>
                <p class="text-xs text-gray-500 eta-display"></p>
            </div>
        </div>
    </div>
 </div>
    </div> <!-- Closes formInner -->
</div> <!-- Closes formContainer -->
    
            
            
           <!-- Right Panel - Map -->
 <div id="mapContainer" class="lg:col-span-2 hidden">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
        <div id="map" class="w-full h-[400px] md:h-[600px]"></div>
    </div>
 </div>
 </div> <!-- Closes the grid with left panel and map -->
        
        <!-- Features Section -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-5xl mb-4">⚡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Real-Time Prices</h3>
                <p class="text-gray-600">Get live prices from all major ride services in seconds</p>
            </div>
            <div class="text-center">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Save Money</h3>
                <p class="text-gray-600">Compare and choose the cheapest option every time</p>
            </div>
            <div class="text-center">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Easy to Use</h3>
                <p class="text-gray-600">Simple interface to find your best ride in one place</p>
            </div>
        </div> <!-- Closes features grid -->
    </div> <!-- Closes max-w-7xl container -->
    
    <!-- Back to Top Button -->
    <button 
        id="backToTop"
        class="hidden fixed bottom-6 right-6 bg-green-600 hover:bg-green-700 text-white p-4 rounded-full shadow-lg z-50 transition-all"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</div> <!-- Closes min-h-screen -->

<script>
    console.log('Script loaded');

 // Initialize the map
 let map;
 let pickupMarker;
 let dropoffMarker;
 let routeControl;

 function initializeMap() {
    console.log('Initializing map');
    // Function to add route to map
  function showRouteOnMap(pickupAddress, dropoffAddress) {
    console.log('Showing route from:', pickupAddress, 'to:', dropoffAddress);
    
    // Geocode the addresses (convert addresses to coordinates)
    const geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=';
    
    // Get pickup coordinates
    fetch(geocodeUrl + encodeURIComponent(pickupAddress + ', Accra, Ghana'))
        .then(response => response.json())
        .then(pickupData => {
            if (pickupData.length === 0) {
                alert('Could not find pickup location. Please enter a valid address in Accra.');
                return;
             }
            if (dropoffData.length === 0) {
                alert('Could not find dropoff location. Please enter a valid address in Accra.');
                return;
             }
            const pickupLat = parseFloat(pickupData[0].lat);
            const pickupLng = parseFloat(pickupData[0].lon);
            
            // Get dropoff coordinates
            return fetch(geocodeUrl + encodeURIComponent(dropoffAddress + ', Accra, Ghana'))
                .then(response => response.json())
                .then(dropoffData => {
                    if (dropoffData.length === 0) {
                        alert('Could not find dropoff location. Please enter a valid address in Accra.');
                        return;
                    }
                    
                    const dropoffLat = parseFloat(dropoffData[0].lat);
                    const dropoffLng = parseFloat(dropoffData[0].lon);
                    
                    // Remove old markers and routes
                    if (pickupMarker) map.removeLayer(pickupMarker);
                    if (dropoffMarker) map.removeLayer(dropoffMarker);
                    if (routeControl) map.removeControl(routeControl);
                    
                    // Add pickup marker (green)
                    pickupMarker = L.marker([pickupLat, pickupLng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(map)
                      .bindPopup('📍 Pickup: ' + pickupAddress)
                      .openPopup();
                    
                    // Add dropoff marker (red)
                    dropoffMarker = L.marker([dropoffLat, dropoffLng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(map)
                      .bindPopup('🎯 Dropoff: ' + dropoffAddress);
                    
                    // Add route line
                   routeControl = L.Routing.control({
                     waypoints: [
                     L.latLng(pickupLat, pickupLng),
                     L.latLng(dropoffLat, dropoffLng)
                     ],
                     routeWhileDragging: false,
                     addWaypoints: false,
                     draggableWaypoints: false,
                     fitSelectedRoutes: true,
                      showAlternatives: false,
                     lineOptions: {
                       styles: [{color: '#16a34a', opacity: 0.8, weight: 5}]
                     },
                      createMarker: function() { return null; }
                   }).addTo(map);

                // 👇 THIS is what extracts distance & duration
                    routeControl.on('routesfound', function(e) {
                   const route       = e.routes[0].summary;
                    const distanceKm  = (route.totalDistance / 1000).toFixed(2);
                   const durationMin = Math.ceil(route.totalTime / 60);

                  console.log('Distance:', distanceKm, 'km');
                 console.log('Duration:', durationMin, 'mins');

                 // Now fetch live fares
                  fetchFares(distanceKm, durationMin);
                   });
                    
                    // Fit map to show both markers
                    const bounds = L.latLngBounds([
                        [pickupLat, pickupLng],
                        [dropoffLat, dropoffLng]
                    ]);
                    map.fitBounds(bounds, { padding: [50, 50] });
                    
                    console.log('Route displayed successfully');
                });
        })
        .catch(error => {
            console.error('Error geocoding addresses:', error);
            alert('Error finding locations. Please try again.');
        });
}
    
    // Create map centered on Accra, Ghana
    map = L.map('map').setView([5.6037, -0.1870], 12);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    console.log('Map initialized');
 }

 // Initialize map when page loads
 document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    loadRecentLocations();
 });
 // Function to add route to map
function showRouteOnMap(pickupAddress, dropoffAddress) {
    console.log('Showing route from:', pickupAddress, 'to:', dropoffAddress);
    
    // Geocode the addresses (convert addresses to coordinates)
    const geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=';
    
    // Get pickup coordinates
    fetch(geocodeUrl + encodeURIComponent(pickupAddress + ', Accra, Ghana'))
        .then(response => response.json())
        .then(pickupData => {
            if (pickupData.length === 0) {
                alert('Could not find pickup location. Please enter a valid address in Accra.');
                return;
            }
            
            const pickupLat = parseFloat(pickupData[0].lat);
            const pickupLng = parseFloat(pickupData[0].lon);
            
            // Get dropoff coordinates
            return fetch(geocodeUrl + encodeURIComponent(dropoffAddress + ', Accra, Ghana'))
                .then(response => response.json())
                .then(dropoffData => {
                    if (dropoffData.length === 0) {
                        alert('Could not find dropoff location. Please enter a valid address in Accra.');
                        return;
                    }
                    
                    const dropoffLat = parseFloat(dropoffData[0].lat);
                    const dropoffLng = parseFloat(dropoffData[0].lon);
                    
                    // Remove old markers and routes
                    if (pickupMarker) map.removeLayer(pickupMarker);
                    if (dropoffMarker) map.removeLayer(dropoffMarker);
                    if (routeControl) map.removeControl(routeControl);
                    
                    // Add pickup marker (green)
                    pickupMarker = L.marker([pickupLat, pickupLng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(map)
                      .bindPopup('📍 Pickup: ' + pickupAddress)
                      .openPopup();
                    
                    // Add dropoff marker (red)
                    dropoffMarker = L.marker([dropoffLat, dropoffLng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(map)
                      .bindPopup('🎯 Dropoff: ' + dropoffAddress);
                    
                    // Add route line
                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(pickupLat, pickupLng),
                            L.latLng(dropoffLat, dropoffLng)
                        ],
                        routeWhileDragging: false,
                        addWaypoints: false,
                        draggableWaypoints: false,
                        fitSelectedRoutes: true,
                        showAlternatives: false,
                        lineOptions: {
                            styles: [{color: '#16a34a', opacity: 0.8, weight: 5}]
                        },
                        createMarker: function() { return null; }
                    }).addTo(map);
                    routeControl.on('routesfound', function(e) {
                   const route       = e.routes[0].summary;
                    const distanceKm  = (route.totalDistance / 1000).toFixed(2);
                   const durationMin = Math.ceil(route.totalTime / 60);

                 console.log('Distance:', distanceKm, 'km');
                 console.log('Duration:', durationMin, 'mins');

                 // Fetch live fares
                 fetchFares(distanceKm, durationMin);
             });
                    // Fit map to show both markers
                    const bounds = L.latLngBounds([
                        [pickupLat, pickupLng],
                        [dropoffLat, dropoffLng]
                    ]);
                    map.fitBounds(bounds, { padding: [50, 50] });
                    
                    console.log('Route displayed successfully');
                    // Show success message
                  const successMsg = document.createElement('div');
                  successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                  successMsg.innerHTML = '✅ Route found! Compare prices below.';
                  document.body.appendChild(successMsg);

// Remove message after 3 seconds
setTimeout(() => {
    successMsg.remove();
}, 3000);
                });
        })
        .catch(error => {
            console.error('Error geocoding addresses:', error);
            alert('Error finding locations. Please try again.');
        });
}
    // Use Current Location Button
    const locationBtn = document.getElementById('currentLocationBtn');
    if (locationBtn) {
        locationBtn.addEventListener('click', function() {
            console.log('Location button clicked');
            
            if (navigator.geolocation) {
                this.innerHTML = '<div class="spinner"></div><span class="ml-2">Getting location...</span>';
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        console.log('Got coordinates:', lat, lng);
                        
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('pickupInput').value = data.display_name;
                                locationBtn.innerHTML = `
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Use Current Location</span>
                                `;
                            });
                    },
                    function(error) {
                        alert('Unable to get your location');
                        console.error('Geolocation error:', error);
                    }
                );
            } else {
                alert('Geolocation not supported');
            }
        });
    }
    
    // Book Ride Function
    function getVehicleType(serviceType) {
    const types = {
        'indrive': 'Standard',
        'bolt':    'Bolt Go',
        'uber':    'UberX',
        'taxi':    'Local Cab'
    };
    return types[serviceType] || serviceType;
}
    function bookRide(rideName, price, serviceType) {
        console.log('bookRide called:', rideName, price);
        // Show payment method selection before booking
       window.location.href = '/payment-methods';
        
        const pickup = document.getElementById('pickupInput').value;
        const dropoff = document.getElementById('dropoffInput').value;
        //save to history
      fetch('/history', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            pickup_address:  pickup,
            dropoff_address: dropoff,
            pickup_lat:      pickupMarker ? pickupMarker.getLatLng().lat : 0,
            pickup_lng:      pickupMarker ? pickupMarker.getLatLng().lng : 0,
            dropoff_lat:     dropoffMarker ? dropoffMarker.getLatLng().lat : 0,
            dropoff_lng:     dropoffMarker ? dropoffMarker.getLatLng().lng : 0,
            provider:        rideName,
            vehicle_type:    getvehicleType(serviceType),
            price:           parseFloat(price),
        })
    }).then(res => res.json())
      .then(data => console.log('Ride saved:', data))
      .catch(err => console.error('Save error:', err));
        
        // Create booking summary
        const bookingDetails = 
            '🚗 Ride Service: ' + rideName + '\n' +
            '💰 Price: GH₵ ' + price + '\n' +
            '📍 Pickup: ' + pickup + '\n' +
            '🎯 Dropoff: ' + dropoff;
        
        // Show confirmation dialog
        const confirmed = confirm('Ready to book your ride?\n\n' + bookingDetails + '\n\nClick OK to proceed to ' + rideName + ' app.');
        
        if (confirmed) {
            console.log('Booking confirmed:', {
                service: rideName,
                price: price,
                pickup: pickup,
                dropoff: dropoff,
                timestamp: new Date()
            });
            
            // Redirect to the respective app
            let appUrl = '';
            
            if (serviceType === 'bolt') {
                appUrl = 'https://bolt.eu/';
            } else if (serviceType === 'uber') {
                appUrl = 'https://m.uber.com/';
            } else if (serviceType === 'indrive') {
                appUrl = 'https://indrive.com/';
            } else if (serviceType === 'taxi') {
                alert('Please call: +233 XX XXX XXXX to book your taxi');
                return;
            }
            
            // Open the app/website
            window.open(appUrl, '_blank');
            
            // Show success message
            alert('Redirecting you to ' + rideName + '... Complete your booking in their app.');
        } else {
            console.log('Booking cancelled');
        }
    }
    
    // Add click event listeners to ride cards
    function setupRideCards() {
        console.log('Setting up ride cards');
        
        // Bolt
        const boltCard = document.getElementById('boltCard');
        if (boltCard) {
            boltCard.addEventListener('click', function() {
                bookRide('Bolt', '25.50', 'bolt');
            });
            console.log('Bolt card listener added');
        }
        
        // Uber
        const uberCard = document.getElementById('uberCard');
        if (uberCard) {
            uberCard.addEventListener('click', function() {
                bookRide('Uber', '28.00', 'uber');
            });
            console.log('Uber card listener added');
        }
        
        // inDrive
        const indriveCard = document.getElementById('indriveCard');
        if (indriveCard) {
            indriveCard.addEventListener('click', function() {
                bookRide('inDrive', '22.00', 'indrive');
            });
            console.log('inDrive card listener added');
        }
        // Show/hide back to top button
        window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 300) {
        backToTop.classList.remove('hidden');
        } else {
        backToTop.classList.add('hidden');
      }
     });
        
        // Taxi
        const taxiCard = document.getElementById('taxiCard');
        if (taxiCard) {
            taxiCard.addEventListener('click', function() {
                bookRide('Taxi', '30.00', 'taxi');
            });
            console.log('Taxi card listener added');
        }
    }
    
    // Compare Rides Button
    const compareBtn = document.getElementById('compareBtn');
    if (compareBtn) {
        compareBtn.addEventListener('click', function() {
            console.log('Compare button clicked');
            
            const pickup = document.getElementById('pickupInput').value;
            const dropoff = document.getElementById('dropoffInput').value;
            
            console.log('Pickup:', pickup);
            console.log('Dropoff:', dropoff);
            
            // Validate inputs
            if (!pickup || !dropoff) {
                // Add red border to empty fields
                   const pickupInput = document.getElementById('pickupInput');
                   const dropoffInput = document.getElementById('dropoffInput');
    
                 if (!pickup) {
                   pickupInput.classList.add('border-red-500', 'border-2');
                   pickupInput.focus();
                   } else {
                    pickupInput.classList.remove('border-red-500', 'border-2');
                   }
    
                 if (!dropoff) {
                 dropoffInput.classList.add('border-red-500', 'border-2');
                  } else {
                 dropoffInput.classList.remove('border-red-500', 'border-2');
                  }
                alert('Please enter both pickup and dropoff locations');
                return;
                }
                  // Remove red borders if both fields are filled
                   document.getElementById('pickupInput').classList.remove('border-red-500', 'border-2');
                   document.getElementById('dropoffInput').classList.remove('border-red-500', 'border-2');
            
             // Show loading
             this.innerHTML = '<div class="spinner"></div><span class="ml-2">Comparing rides...</span>';
             console.log('Showing loading state');
             this.disabled = true;
             this.classList.add('opacity-50', 'cursor-not-allowed');
             // Simulate search
             setTimeout(function() {
                console.log('Attempting to show results');
                
                const ridesSection = document.getElementById('availableRides');
                console.log('Rides section found:', ridesSection);
                
                if (ridesSection) {
                  ridesSection.classList.remove('hidden');
                  console.log('Hidden class removed');
    
                  // Switch to side-by-side layout
                 const formContainer = document.getElementById('formContainer');
                 const mapContainer = document.getElementById('mapContainer');
    
                 // Change form from centered to left column
                 const formInner = document.getElementById('formInner');
                 formContainer.classList.remove('lg:col-span-3');
                 formContainer.classList.add('lg:col-span-1');
                 formInner.classList.remove('max-w-4xl', 'mx-auto');
    
                 // Show map container
                 mapContainer.classList.remove('hidden');
    
                 // Re-initialize map size (needed after showing hidden element)
                 setTimeout(() => {
                  map.invalidateSize();
                }, 100);
    
                  // Setup ride card click handlers after cards are visible
                 setupRideCards();
    
                  // Show route on map
                  showRouteOnMap(pickup, dropoff);
                  saveLocation(pickup, pickup + ', Accra, Ghana'); 
                  saveLocation(dropoff, dropoff + ', Accra, Ghana');
    
                 // Scroll to results
                 ridesSection.scrollIntoView({ behavior: 'smooth' });
                 }
                 compareBtn.disabled = false;
                 compareBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                 // Reset button
                 compareBtn.innerHTML = 
                    '<span>Compare Rides</span>' +
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>' +
                    '</svg>';
            }, 1500);
        });
    } else {
        console.error('Compare button not found!');
    }
    // Clear Button
const clearBtn = document.getElementById('clearBtn');
if (clearBtn) {
    clearBtn.addEventListener('click', function() {
        console.log('Clear button clicked');
        
        // Clear input fields
        document.getElementById('pickupInput').value = '';
        document.getElementById('dropoffInput').value = '';
        
        // Remove validation errors
        document.getElementById('pickupInput').classList.remove('border-red-500', 'border-2');
        document.getElementById('dropoffInput').classList.remove('border-red-500', 'border-2');
        
        // Hide results
        document.getElementById('availableRides').classList.add('hidden');
        // Reset to centered layout
        const formContainer = document.getElementById('formContainer');
        const mapContainer = document.getElementById('mapContainer');

        const formInner = document.getElementById('formInner');
        formContainer.classList.remove('lg:col-span-1');
        formContainer.classList.add('lg:col-span-3');
        formInner.classList.add('max-w-4xl', 'mx-auto');
        mapContainer.classList.add('hidden');
        // Remove markers and route from map
        if (pickupMarker) map.removeLayer(pickupMarker);
        if (dropoffMarker) map.removeLayer(dropoffMarker);
        if (routeControl) map.removeControl(routeControl);
        
        // Reset map to default view (Accra center)
        map.setView([5.6037, -0.1870], 12);
        
        console.log('Form cleared');
    });
 }
 // Fetch live fares from Laravel API
function fetchFares(distanceKm, durationMin) {
    console.log('Fetching fares for', distanceKm, 'km,', durationMin, 'mins');

    fetch(`/api/fares?distance_km=${distanceKm}&duration_min=${durationMin}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fares received:', data);
            updateRideCards(data.fares, data.best_savings, data.savings_pct, data.provider);
        })
        .catch(error => {
            console.error('Error fetching fares:', error);
        });
}

// Update the ride cards with live prices
function updateRideCards(fares, bestSavings, savingsPct, bestProvider) {
    const maxFare = Math.max(...fares.map(f => f.fare));

   // Update best deal banner
const bestDealEl = document.getElementById('bestDealText');
const savingsPctEl = document.getElementById('savingsPctText');

if (bestDealEl) bestDealEl.innerHTML =
    `Save up to GH₵ ${bestSavings.toFixed(2)} with ${bestProvider}!`;
if (savingsPctEl) savingsPctEl.innerHTML =
    `${savingsPct}% OFF`;
    // Map provider names to card IDs
    const cardMap = {
        'inDrive': 'indriveCard',
        'Bolt':    'boltCard',
        'Uber':    'uberCard',
        'Taxi':    'taxiCard'
    };

    fares.forEach((ride, index) => {
        const cardId = cardMap[ride.name];
        if (!cardId) return;

        const card    = document.getElementById(cardId);
        if (!card) return;

        const saving  = (maxFare - ride.fare).toFixed(2);

        // Update price
        card.querySelector('.text-2xl.font-bold.text-green-600').textContent =
            `GH₵ ${ride.fare.toFixed(2)}`;

        // Update savings label
        const savingEl = card.querySelector('.text-xs.text-green-600.font-semibold');
        if (savingEl) {
            savingEl.textContent = saving > 0 ? `Save GH₵ ${saving}` : '';
        }

        // Highlight cheapest card
        if (index === 0) {
            card.classList.add('border-2', 'border-green-500');
        } else {
            card.classList.remove('border-2', 'border-green-500');
        }
    });

    // Also update bookRide click handlers with new prices
    fares.forEach(ride => {
        const cardMap2 = {
            'inDrive': { id: 'indriveCard', type: 'indrive' },
            'Bolt':    { id: 'boltCard',    type: 'bolt'    },
            'Uber':    { id: 'uberCard',    type: 'uber'    },
            'Taxi':    { id: 'taxiCard',    type: 'taxi'    },
        };
        const info = cardMap2[ride.name];
        if (!info) return;

        const card = document.getElementById(info.id);
        if (card) {
            card.onclick = () => bookRide(ride.name, ride.fare.toFixed(2), info.type);
        }
    });
}
// Load recent locations on page load
function loadRecentLocations() {
    fetch('/recent-locations')
        .then(r => r.json())
        .then(locations => {
            if (!locations.length) return;

            const list      = document.getElementById('recentList');
            const container = document.getElementById('recentLocations');

            list.innerHTML = locations.map(loc => `
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition border border-gray-100"
                     onclick="fillLocation('${loc.location_name.replace(/'/g, "\\'")}')">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0 text-sm">
                        📍
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">${loc.location_name}</p>
                        <p class="text-xs text-gray-400">${loc.address}</p>
                    </div>
                </div>
            `).join('');

            container.classList.remove('hidden');
        })
        .catch(() => {});
}

// Fill whichever input is empty first
function fillLocation(name) {
    const pickup  = document.getElementById('pickupInput');
    const dropoff = document.getElementById('dropoffInput');

    if (!pickup.value) {
        pickup.value = name;
        pickup.classList.remove('border-red-500', 'border-2');
        document.getElementById('dropoffInput').focus();
    } else if (!dropoff.value) {
        dropoff.value = name;
        dropoff.classList.remove('border-red-500', 'border-2');
    } else {
        pickup.value = name;
    }
}

// Save location to history
function saveLocation(name, address) {
    fetch('/save-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            location_name: name,
            address:       address
        })
    })
    .then(r => r.json())
    .then(data => console.log('Save location response:', data))
    .catch(err => console.error('Save location error:', err));
}
 // Allow Enter key to submit
 document.getElementById('pickupInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('dropoffInput').focus();
    }
 });

 document.getElementById('dropoffInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('compareBtn').click();
    }
});
</script>
@endsection