<?php 

require_once '../backend/init.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - List Surplus Food</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .form-container {
            max-width: 800px;
            margin: 40px auto;
        }
        #location-picker-map {
            height: 300px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 15px;
        }
        .search-row {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="card form-container">
                <div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px">
                    <h2 style="color: var(--primary-color)">Submit Surplus Donation</h2>
                    <p style="font-size: 0.9rem; color: #666">Search for your address or drag the marker to pin your exact pickup location.</p>
                </div>

                <form id="listing-form" action="../backend/api_listings.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <!-- Hidden Lat/Lng fields -->
                    <input type="hidden" name="latitude" id="lat-field">
                    <input type="hidden" name="longitude" id="lng-field">

                    <div class="form-group">
                        <label class="form-label">Listing Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Fresh Baked Bagels" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px">
                        <div class="form-group">
                            <label class="form-label">Food Category</label>
                            <select name="category" class="form-control" required>
                                <option value="Produce">Fresh Produce</option>
                                <option value="Baked Goods">Bakery Items</option>
                                <option value="Dairy">Dairy Products</option>
                                <option value="Meals">Prepared Meals</option>
                                <option value="Pantry">Pantry Staples</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Approx. Quantity (units/lbs)</label>
                            <input type="number" name="quantity" class="form-control" placeholder="10" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Available Until (Date & Time)</label>
                        <input type="datetime-local" name="available_until" class="form-control" required>
                    </div>

                    <!-- Map Search Section -->
                    <div class="form-group" style="margin-top: 30px">
                        <label class="form-label">Pickup Location Picker</label>
                        <div class="search-row">
                            <input type="text" id="address-search" class="form-control" placeholder="Search for your street or landmark (e.g. Bandra, Mumbai)">
                            <button type="button" id="search-btn" class="btn btn-secondary">Search</button>
                        </div>
                        <div id="location-picker-map"></div>
                        <p id="location-status" style="font-size: 11px; color: #666; margin-top: 8px">
                            📍 Current coordinates: <span id="coords-display">Not set</span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pickup Instructions</label>
                        <textarea name="description" class="form-control" style="height: 80px" placeholder="e.g. 'Ring bell at Gate 4', 'Near the blue mailbox'"></textarea>
                    </div>

                    <div class="form-group" style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px dashed #ccc">
                        <label class="form-label" style="display: flex; align-items: center; gap: 10px">
                            <i data-icon="image" class="icon"></i> Upload Food Image (Optional)
                        </label>
                        <input type="file" name="food_image" accept="image/*" class="form-control" style="background: white">
                    </div>

                    <div style="margin-top: 40px">
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 100%; padding: 15px" disabled>
                            Please pin your location on the map
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Operation Center &copy; 2026
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const MUMBAI_CENTER = [19.0760, 72.8777];
            const map = L.map('location-picker-map').setView(MUMBAI_CENTER, 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker(MUMBAI_CENTER, { draggable: true }).addTo(map);
            
            const latField = document.getElementById('lat-field');
            const lngField = document.getElementById('lng-field');
            const coordsDisplay = document.getElementById('coords-display');
            const submitBtn = document.getElementById('submit-btn');
            const searchBtn = document.getElementById('search-btn');
            const searchInput = document.getElementById('address-search');

            function updateCoords(lat, lng) {
                latField.value = lat.toFixed(6);
                lngField.value = lng.toFixed(6);
                coordsDisplay.textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                submitBtn.disabled = false;
                submitBtn.textContent = "Publish Donation Batch";
            }

            // Update on drag
            marker.on('dragend', (e) => {
                const pos = marker.getLatLng();
                updateCoords(pos.lat, pos.lng);
            });

            // Update on map click
            map.on('click', (e) => {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });

            // Search Logic (Nominatim)
            searchBtn.addEventListener('click', () => {
                const query = searchInput.value;
                if(!query) return;

                searchBtn.textContent = 'Searching...';
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        if(data.length > 0) {
                            const result = data[0];
                            const lat = parseFloat(result.lat);
                            const lon = parseFloat(result.lon);
                            const pos = [lat, lon];
                            
                            map.setView(pos, 16);
                            marker.setLatLng(pos);
                            updateCoords(lat, lon);
                        } else {
                            alert("Location not found. Please try a different address or pin manually.");
                        }
                    })
                    .finally(() => {
                        searchBtn.textContent = 'Search';
                    });
            });

            // Try to pre-fill with current location for convenience
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    const userPos = [pos.coords.latitude, pos.coords.longitude];
                    map.setView(userPos, 15);
                    marker.setLatLng(userPos);
                    updateCoords(pos.coords.latitude, pos.coords.longitude);
                });
            }
        });
    </script>
</body>
</html>
