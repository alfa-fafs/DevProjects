<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>OptiDrive — Compare Rides</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green: #39C70D;
            --green-dark: #2ea00a;
            --white: #FFFFFF;
            --black: #000000;
            --gray-light: #F5F5F5;
            --gray-border: #E8E8E8;
            --text-muted: #888;
            --blue: #4A80F0;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            background: #f0f0f0;
        }

        /* ── MAP ── */
        #map {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* Hide Leaflet routing panel */
        .leaflet-routing-container { display: none !important; }

        /* ── TOP NAV ── */
        .top-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 10;
            padding: 52px 20px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border-radius: 20px;
            padding: 8px 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
        }

        .nav-logo-icon {
            width: 24px; height: 24px;
            background: white;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            border: 1.5px solid var(--green);
        }

        .nav-logo-dot {
            width: 12px; height: 12px;
            background: var(--green);
            border-radius: 50%;
        }

        .nav-logo span {
            font-size: 15px;
            font-weight: 700;
            color: var(--green);
        }

        .nav-profile {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            text-decoration: none;
            overflow: hidden;
        }

        .nav-profile svg {
            width: 20px; height: 20px;
            stroke: #555; fill: none;
            stroke-width: 2;
        }

        /* ── LOCATION BUTTON (current location) ── */
        .locate-btn {
            position: fixed;
            right: 20px;
            bottom: 340px;
            z-index: 10;
            width: 44px; height: 44px;
            border-radius: 50%;
            background: white;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .locate-btn:hover { background: var(--gray-light); }

        .locate-btn svg {
            width: 20px; height: 20px;
            stroke: var(--blue); fill: none;
            stroke-width: 2;
            stroke-linecap: round; stroke-linejoin: round;
        }

        /* ── BOTTOM SHEET ── */
        .bottom-sheet {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 20;
            background: white;
            border-radius: 24px 24px 0 0;
            box-shadow: 0 -4px 30px rgba(0,0,0,0.1);
            padding: 12px 20px 40px;
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }

        /* Drag handle */
        .drag-handle {
            width: 40px; height: 4px;
            background: var(--gray-border);
            border-radius: 2px;
            margin: 0 auto 20px;
        }

        /* Location rows */
        .location-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: var(--gray-light);
            border-radius: 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.2s;
            border: 1.5px solid transparent;
        }

        .location-row:hover { background: #eefbe8; border-color: var(--green); }
        .location-row.active { background: #eefbe8; border-color: var(--green); }

        .location-dot {
            width: 14px; height: 14px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-blue  { background: var(--blue); }
        .dot-green { background: var(--green); }

        .location-info { flex: 1; min-width: 0; }

        .location-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .location-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--black);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .location-value.placeholder { color: #bbb; font-weight: 400; }

        .location-edit {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: white;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .location-edit svg {
            width: 14px; height: 14px;
            stroke: #999; fill: none;
            stroke-width: 2;
        }

        /* Divider between rows */
        .rows-divider {
            display: flex;
            align-items: center;
            padding: 0 16px;
            margin: -4px 0;
            z-index: 2;
            position: relative;
        }

        .divider-dots {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-left: 20px;
        }

        .divider-dot {
            width: 3px; height: 3px;
            border-radius: 50%;
            background: var(--gray-border);
        }

        /* Continue button */
        .continue-btn {
            width: 100%;
            padding: 16px;
            background: var(--green);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.2s, transform 0.1s, opacity 0.2s;
        }

        .continue-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
        .continue-btn:active { transform: translateY(0); }
        .continue-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

        .btn-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        .btn-spinner.show { display: block; }
        .btn-label.hide { display: none; }

        /* ── INPUT MODAL ── */
        .input-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            background: white;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
            display: flex;
            flex-direction: column;
            padding: 52px 20px 40px;
        }

        .input-modal.open { transform: translateY(0); }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .modal-back {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--gray-light);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }

        .modal-back svg {
            width: 18px; height: 18px;
            stroke: black; fill: none;
            stroke-width: 2.5;
            stroke-linecap: round; stroke-linejoin: round;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--black);
        }

        .modal-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--gray-light);
            border: 1.5px solid var(--gray-border);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            color: var(--black);
            outline: none;
            margin-bottom: 16px;
            transition: border-color 0.2s;
        }

        .modal-input:focus { border-color: var(--green); background: white; }

        .suggestion-list { flex: 1; overflow-y: auto; }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 4px;
            border-bottom: 1px solid var(--gray-border);
            cursor: pointer;
            transition: background 0.15s;
        }

        .suggestion-item:hover { background: #f9fff7; border-radius: 8px; }

        .suggestion-icon {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--gray-light);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .suggestion-icon svg {
            width: 16px; height: 16px;
            stroke: #666; fill: none;
            stroke-width: 2;
        }

        .suggestion-text .name {
            font-size: 14px;
            font-weight: 600;
            color: var(--black);
        }

        .suggestion-text .address {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── RIDES BOTTOM SHEET ── */
        .rides-sheet {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 30;
            background: white;
            border-radius: 24px 24px 0 0;
            box-shadow: 0 -4px 30px rgba(0,0,0,0.12);
            padding: 12px 20px 40px;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            max-height: 75vh;
            overflow-y: auto;
        }

        .rides-sheet.open { transform: translateY(0); }

        .rides-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .rides-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--black);
        }

        .rides-close {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--gray-light);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }

        .rides-close svg {
            width: 14px; height: 14px;
            stroke: #666; fill: none;
            stroke-width: 2.5;
        }

        /* Best deal banner */
        .best-deal {
            background: linear-gradient(135deg, var(--green), #2ea00a);
            border-radius: 16px;
            padding: 14px 16px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .best-deal-left { display: flex; align-items: center; gap: 10px; }
        .best-deal-left .icon { font-size: 24px; }
        .best-deal-label { font-size: 11px; opacity: 0.85; }
        .best-deal-text { font-size: 14px; font-weight: 700; }
        .best-deal-pct { font-size: 22px; font-weight: 800; }
        .best-deal-sub { font-size: 10px; opacity: 0.8; }

        /* Ride card */
        .ride-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            background: var(--gray-light);
            border-radius: 16px;
            margin-bottom: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s, background 0.2s;
        }

        .ride-card:hover { border-color: var(--green); background: #f4fff0; }
        .ride-card.cheapest { border-color: var(--green); background: #f4fff0; }

        .ride-card-left { display: flex; align-items: center; gap: 12px; }

        .ride-icon {
            width: 46px; height: 46px;
            border-radius: 50%;
            background: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .ride-name {
            font-size: 15px; font-weight: 700;
            color: var(--black);
            display: flex; align-items: center; gap: 6px;
        }

        .cheapest-badge {
            font-size: 10px; font-weight: 700;
            background: var(--green); color: white;
            padding: 2px 8px; border-radius: 10px;
        }

        .ride-type { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        .ride-card-right { text-align: right; }

        .ride-price {
            font-size: 18px; font-weight: 700;
            color: var(--green);
        }

        .ride-saving {
            font-size: 11px; color: var(--green);
            font-weight: 600; margin-top: 2px;
        }

        /* Loading state */
        .loading-rides {
            text-align: center;
            padding: 24px;
            color: var(--text-muted);
            font-size: 14px;
        }

        .loading-spinner {
            width: 28px; height: 28px;
            border: 3px solid var(--gray-border);
            border-top-color: var(--green);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 12px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Map -->
<div id="map"></div>

<!-- Top Nav -->
<div class="top-nav">
    <div class="nav-logo">
        <div class="nav-logo-icon"><div class="nav-logo-dot"></div></div>
        <span>OptiDrive</span>
    </div>
    <a href="{{ route('profile.edit') }}" class="nav-profile">
        <svg viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
    </a>
</div>

<!-- Locate button -->
<button class="locate-btn" onclick="useCurrentLocation()">
    <svg viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M12 2v3M12 19v3M2 12h3M19 12h3"></path>
    </svg>
</button>

<!-- Bottom Sheet — Location Input -->
<div class="bottom-sheet" id="bottomSheet">
    <div class="drag-handle"></div>

    <!-- Current Location Row -->
    <div class="location-row" id="pickupRow" onclick="openModal('pickup')">
        <div class="location-dot dot-blue"></div>
        <div class="location-info">
            <div class="location-label">Pickup</div>
            <div class="location-value placeholder" id="pickupDisplay">Current Location</div>
        </div>
        <div class="location-edit">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </div>
    </div>

    <!-- Dots connector -->
    <div class="rows-divider">
        <div class="divider-dots">
            <div class="divider-dot"></div>
            <div class="divider-dot"></div>
            <div class="divider-dot"></div>
        </div>
    </div>

    <!-- Where to Row -->
    <div class="location-row" id="dropoffRow" onclick="openModal('dropoff')">
        <div class="location-dot dot-green"></div>
        <div class="location-info">
            <div class="location-label">Destination</div>
            <div class="location-value placeholder" id="dropoffDisplay">Where to?</div>
        </div>
        <div class="location-edit">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
    </div>

    <!-- Continue -->
    <button class="continue-btn" id="continueBtn" onclick="handleCompare()" disabled>
        <div class="btn-inner">
            <span class="btn-label" id="btnLabel">Continue</span>
            <div class="btn-spinner" id="btnSpinner"></div>
        </div>
    </button>
</div>

<!-- Input Modal -->
<div class="input-modal" id="inputModal">
    <div class="modal-header">
        <button class="modal-back" onclick="closeModal()">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
        <div class="modal-title" id="modalTitle">Enter pickup</div>
    </div>

    <input
        type="text"
        class="modal-input"
        id="modalInput"
        placeholder="Search for a location..."
        autocomplete="off"
    />

    <div class="suggestion-list" id="suggestionList">
        <!-- Use current location suggestion -->
        <div class="suggestion-item" onclick="useCurrentLocation(); closeModal();">
            <div class="suggestion-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M12 2v3M12 19v3M2 12h3M19 12h3"></path></svg>
            </div>
            <div class="suggestion-text">
                <div class="name">Use current location</div>
                <div class="address">GPS detected location</div>
            </div>
        </div>
    </div>
</div>

<!-- Rides Bottom Sheet -->
<div class="rides-sheet" id="ridesSheet">
    <div class="drag-handle"></div>
    <div class="rides-header">
        <div class="rides-title">Available Rides</div>
        <button class="rides-close" onclick="closeRides()">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- Best deal banner -->
    <div class="best-deal">
        <div class="best-deal-left">
            <div class="icon">💰</div>
            <div>
                <div class="best-deal-label">Best Deal Available</div>
                <div class="best-deal-text" id="bestDealText">Calculating...</div>
            </div>
        </div>
        <div style="text-align:right">
            <div class="best-deal-pct" id="savingsPctText">--%</div>
            <div class="best-deal-sub">vs most expensive</div>
        </div>
    </div>

    <!-- Ride cards container -->
    <div id="rideCards">
        <div class="loading-rides">
            <div class="loading-spinner"></div>
            Fetching best prices...
        </div>
    </div>
</div>

<script>
    // ── State ──
    let map, pickupMarker, dropoffMarker, routeControl;
    let pickupLat, pickupLng, dropoffLat, dropoffLng;
    let pickupAddress = '', dropoffAddress = '';
    let activeField = 'pickup';
    let searchTimeout;

    // ── Map Init ──
    map = L.map('map', { zoomControl: false }).setView([5.6037, -0.1870], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    // ── Modal ──
    function openModal(field) {
        activeField = field;
        document.getElementById('modalTitle').textContent =
            field === 'pickup' ? 'Enter pickup location' : 'Where to?';
        document.getElementById('modalInput').value =
            field === 'pickup' ? pickupAddress : dropoffAddress;
        document.getElementById('inputModal').classList.add('open');
        setTimeout(() => document.getElementById('modalInput').focus(), 350);
    }

    function closeModal() {
        document.getElementById('inputModal').classList.remove('open');
        document.getElementById('suggestionList').innerHTML = getDefaultSuggestions();
    }

    function getDefaultSuggestions() {
        return `
        <div class="suggestion-item" onclick="useCurrentLocation(); closeModal();">
            <div class="suggestion-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M12 2v3M12 19v3M2 12h3M19 12h3"></path></svg>
            </div>
            <div class="suggestion-text">
                <div class="name">Use current location</div>
                <div class="address">GPS detected location</div>
            </div>
        </div>`;
    }

    // ── Search ──
    document.getElementById('modalInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (q.length < 3) {
            document.getElementById('suggestionList').innerHTML = getDefaultSuggestions();
            return;
        }
        searchTimeout = setTimeout(() => searchPlaces(q), 400);
    });

    function searchPlaces(query) {
        fetch('/api/geocode?q=' + encodeURIComponent(query + ', Accra, Ghana'))
            .then(r => r.json())
            .then(results => {
                const list = document.getElementById('suggestionList');
                if (!results.length) {
                    list.innerHTML = `<div style="padding:20px;text-align:center;color:#aaa;font-size:14px">No results found</div>`;
                    return;
                }
                list.innerHTML = results.slice(0, 6).map(r => `
                    <div class="suggestion-item" onclick="selectPlace('${r.display_name.replace(/'/g, "\\'")}', ${r.lat}, ${r.lon})">
                        <div class="suggestion-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="suggestion-text">
                            <div class="name">${r.display_name.split(',')[0]}</div>
                            <div class="address">${r.display_name.split(',').slice(1,3).join(',')}</div>
                        </div>
                    </div>
                `).join('');
            })
            .catch(() => {});
    }

    function selectPlace(name, lat, lng) {
        const shortName = name.split(',')[0];

        if (activeField === 'pickup') {
            pickupAddress = shortName;
            pickupLat     = parseFloat(lat);
            pickupLng     = parseFloat(lng);
            document.getElementById('pickupDisplay').textContent = shortName;
            document.getElementById('pickupDisplay').classList.remove('placeholder');
            setMarker('pickup', pickupLat, pickupLng, shortName);
        } else {
            dropoffAddress = shortName;
            dropoffLat     = parseFloat(lat);
            dropoffLng     = parseFloat(lng);
            document.getElementById('dropoffDisplay').textContent = shortName;
            document.getElementById('dropoffDisplay').classList.remove('placeholder');
            setMarker('dropoff', dropoffLat, dropoffLng, shortName);
        }

        closeModal();
        checkEnableButton();

        // If both set, draw route
        if (pickupAddress && dropoffAddress) {
            drawRoute();
        }
    }

    // ── Markers ──
    function setMarker(type, lat, lng, label) {
        const icon = L.divIcon({
            className: '',
            html: `<div style="
                width:16px;height:16px;
                border-radius:50%;
                background:${type === 'pickup' ? '#4A80F0' : '#39C70D'};
                border:3px solid white;
                box-shadow:0 2px 8px rgba(0,0,0,0.3)
            "></div>`,
            iconAnchor: [8, 8]
        });

        if (type === 'pickup') {
            if (pickupMarker) map.removeLayer(pickupMarker);
            pickupMarker = L.marker([lat, lng], { icon })
                .addTo(map).bindPopup('📍 ' + label);
        } else {
            if (dropoffMarker) map.removeLayer(dropoffMarker);
            dropoffMarker = L.marker([lat, lng], { icon })
                .addTo(map).bindPopup('🎯 ' + label);
        }

        map.setView([lat, lng], 14);
    }

    // ── Route ──
    function drawRoute() {
        if (routeControl) map.removeControl(routeControl);

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
                styles: [{ color: '#4A80F0', opacity: 0.85, weight: 5 }]
            },
            createMarker: () => null
        }).addTo(map);

        routeControl.on('routesfound', function(e) {
            const summary     = e.routes[0].summary;
            const distanceKm  = (summary.totalDistance / 1000).toFixed(2);
            const durationMin = Math.ceil(summary.totalTime / 60);
            fetchFares(distanceKm, durationMin);
        });

        // Fit both markers
        const bounds = L.latLngBounds([
            [pickupLat, pickupLng],
            [dropoffLat, dropoffLng]
        ]);
        map.fitBounds(bounds, { padding: [60, 60], maxZoom: 15 });
    }

    // ── Fares ──
    function fetchFares(distanceKm, durationMin) {
        openRidesSheet();

        fetch(`/api/fares?distance_km=${distanceKm}&duration_min=${durationMin}`)
            .then(r => r.json())
            .then(data => renderRides(data))
            .catch(() => {});
    }

    function renderRides(data) {
        const maxFare = Math.max(...data.fares.map(f => f.fare));

        document.getElementById('bestDealText').textContent =
            `Save GH₵ ${data.best_savings.toFixed(2)} with ${data.provider}!`;
        document.getElementById('savingsPctText').textContent =
            `${data.savings_pct}% OFF`;

        const icons = { inDrive: '🚙', Bolt: '⚡', Uber: '🚗', Taxi: '🚕' };

        document.getElementById('rideCards').innerHTML = data.fares.map((ride, i) => {
            const saving = (maxFare - ride.fare).toFixed(2);
            return `
            <div class="ride-card ${i === 0 ? 'cheapest' : ''}" onclick="bookRide('${ride.name}', '${ride.fare.toFixed(2)}', '${ride.type}')">
                <div class="ride-card-left">
                    <div class="ride-icon">${icons[ride.name] || '🚗'}</div>
                    <div>
                        <div class="ride-name">
                            ${ride.name}
                            ${i === 0 ? '<span class="cheapest-badge">CHEAPEST</span>' : ''}
                        </div>
                        <div class="ride-type">${ride.type}</div>
                    </div>
                </div>
                <div class="ride-card-right">
                    <div class="ride-price">${ride.currency} ${ride.fare.toFixed(2)}</div>
                    ${saving > 0 ? `<div class="ride-saving">Save ${ride.currency} ${saving}</div>` : ''}
                </div>
            </div>`;
        }).join('');
    }

    function openRidesSheet() {
        document.getElementById('ridesSheet').classList.add('open');
        document.getElementById('bottomSheet').style.transform = 'translateY(100%)';
    }

    function closeRides() {
        document.getElementById('ridesSheet').classList.remove('open');
        document.getElementById('bottomSheet').style.transform = '';
    }

    // ── Book ──
    function bookRide(name, price, type) {
        // Save to history
        fetch('/history', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                pickup_address:  pickupAddress,
                dropoff_address: dropoffAddress,
                pickup_lat:      pickupLat,
                pickup_lng:      pickupLng,
                dropoff_lat:     dropoffLat,
                dropoff_lng:     dropoffLng,
                provider:        name,
                vehicle_type:    type,
                price:           parseFloat(price),
            })
        }).catch(() => {});

        // Redirect to provider
        const urls = {
            'inDrive': 'https://indrive.com/',
            'Bolt':    'https://bolt.eu/',
            'Uber':    'https://m.uber.com/',
            'Taxi':    null
        };

        if (urls[name]) {
            window.open(urls[name], '_blank');
        } else {
            alert('Please call a local taxi to book your ride.');
        }
    }

    // ── Current Location ──
    function useCurrentLocation() {
        if (!navigator.geolocation) return;

        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(r => r.json())
                .then(data => {
                    const name = data.address.suburb || data.address.neighbourhood || 'Current Location';
                    pickupAddress = name;
                    pickupLat = lat; pickupLng = lng;
                    document.getElementById('pickupDisplay').textContent = name;
                    document.getElementById('pickupDisplay').classList.remove('placeholder');
                    setMarker('pickup', lat, lng, name);
                    checkEnableButton();
                });
        });
    }

    // ── Button State ──
    function checkEnableButton() {
        document.getElementById('continueBtn').disabled = !(pickupAddress && dropoffAddress);
    }

    function handleCompare() {
        if (!pickupAddress || !dropoffAddress) return;
        document.getElementById('btnLabel').classList.add('hide');
        document.getElementById('btnSpinner').classList.add('show');
        document.getElementById('continueBtn').disabled = true;

        setTimeout(() => {
            document.getElementById('btnLabel').classList.remove('hide');
            document.getElementById('btnSpinner').classList.remove('show');
            document.getElementById('continueBtn').disabled = false;
            drawRoute();
        }, 1000);
    }
</script>
</body>
</html>