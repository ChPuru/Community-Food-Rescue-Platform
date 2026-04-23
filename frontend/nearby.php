<?php 

require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Rescue Radar Mumbai</title>
    
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .map-popup-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            margin-top: 15px;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: transform 0.2s, background 0.2s;
        }
        .map-popup-btn:hover {
            background: #235d25;
            transform: translateY(-2px);
        }
        .dist-tag {
            background: #e3f2fd;
            color: #1565c0;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: bold;
        }
        .leaflet-popup-content-wrapper {
            padding: 10px;
            border-radius: 12px;
            box-shadow: var(--shadow-hover);
        }
        .leaflet-popup-content {
            margin: 15px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 style="color: var(--primary-color)">Rescue Radar</h1>
                    <p style="color: #666">Discover live donations and get turn-by-turn navigation.</p>
                </div>
                <div style="background: white; border: 1.5px solid var(--primary-color); color: var(--primary-color); padding: 8px 18px; border-radius: 50px; font-weight: 600; font-size: 0.85rem">
                    <span id="map-batch-count">0</span> Active Batches
                </div>
            </div>

            <div id="live-map" style="margin-bottom: 40px; height: 500px; border-radius: var(--radius); overflow: hidden; border: 1px solid #ddd"></div>

            <h2 class="mb-4">Live Listings Near You</h2>
            <div id="nearby-listings-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 30px">
                <div class="skeleton" style="height: 250px"></div>
                <div class="skeleton" style="height: 250px"></div>
                <div class="skeleton" style="height: 250px"></div>
            </div>
        </div>
    </main>

    <footer style="background: #fff; border-top: 1px solid #ddd; padding: 40px 0; text-align: center; margin-top: 60px">
        <div class="container">
            <p style="font-weight: bold; color: var(--primary-color)">FoodCycle Platform &copy; 2026</p>
            <p style="font-size: 12px; color: #888">Intelligent Food Rescue Network</p>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    
    <script>
        let userLocation = [19.0760, 72.8777]; // Default Mumbai
        const map = L.map('live-map').setView(userLocation, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function initApp() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    userLocation = [pos.coords.latitude, pos.coords.longitude];
                    map.setView(userLocation, 13);
                    L.circle(userLocation, { radius: 500, color: '#2196f3' }).addTo(map).bindPopup("You are here");
                    fetchListings();
                }, () => fetchListings());
            } else {
                fetchListings();
            }
        }

        function fetchListings() {
            const grid = document.getElementById('nearby-listings-grid');
            const countLabel = document.getElementById('map-batch-count');

            fetch('../backend/api_listings.php')
                .then(r => r.json())
                .then(d => {
                    if(d.status === 'success') {
                        const listings = d.data;
                        countLabel.textContent = listings.length;
                        grid.innerHTML = '';

                        if(listings.length === 0) {
                            grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align:center; padding:40px; color:#888">No donations found. Check back later!</div>';
                            return;
                        }

                        listings.forEach(item => {
                            const lat = parseFloat(item.latitude) || (19.0760 + (Math.random() - 0.5) * 0.1);
                            const lng = parseFloat(item.longitude) || (72.8777 + (Math.random() - 0.5) * 0.1);
                            
                            const dist = calculateDistance(userLocation[0], userLocation[1], lat, lng);
                            const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

                            L.marker([lat, lng]).addTo(map)
                                .bindPopup(`
                                    <div style="font-family: 'Lora', serif; width: 220px">
                                        <strong style="color:var(--primary-color); font-size: 1.2rem; display: block; margin-bottom: 5px">${item.title}</strong>
                                        <div style="color: #666; font-size: 0.85rem; margin-bottom: 10px">
                                            📍 ${item.operator_name}<br>
                                            📏 ${dist.toFixed(1)} km away
                                        </div>
                                        <a href="${gmapsUrl}" target="_blank" class="map-popup-btn">Navigate to Pickup</a>
                                    </div>
                                `);

                            const card = document.createElement('div');
                            card.className = 'card';
                            card.style.overflow = 'hidden';
                            card.innerHTML = `
                                <img src="${item.image_path || 'assets/img/pantry.png'}" class="category-img" style="height:180px; object-fit:cover">
                                <div style="padding: 20px">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 style="font-size: 1.2rem; color: var(--primary-color)">${item.title}</h3>
                                        <span class="dist-tag">${dist.toFixed(1)} km</span>
                                    </div>
                                    <p class="line-clamp-3" style="font-size: 0.85rem; color: #666; margin-bottom: 20px; min-height: 40px">
                                        Available at ${item.operator_name}. ${item.description}
                                    </p>
                                    <div class="flex gap-2">
                                        <a href="${gmapsUrl}" target="_blank" class="btn btn-outline" style="flex:1.2; text-align:center; padding: 10px; font-size:12px">Get Directions</a>
                                        <button class="btn btn-primary" style="flex:1; padding: 10px; font-size:12px" onclick="location.href='feed.php'">Claim</button>
                                    </div>
                                </div>
                            `;
                            grid.appendChild(card);
                        });
                    }
                });
        }

        initApp();
    </script>
</body>
</html>
