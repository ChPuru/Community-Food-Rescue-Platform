<?php 
/*
   Rescue Interactive Radar
   Mapping of active food donations using Leaflet.js
   Unit 5: Geographical API Integration logic
*/
require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Community Food Rescue Platform</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/styles.css">
    
    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 style="color: var(--primary-color)">Rescue Radar</h1>
                    <p style="color: #666">Discover and navigate to available food batches in real-time.</p>
                </div>
                <div style="background: white; border: 1.5px solid var(--primary-color); color: var(--primary-color); padding: 8px 18px; border-radius: 50px; font-weight: 600; font-size: 0.85rem">
                    12 Batches Available
                </div>
            </div>

            <!-- Live Map Section -->
            <div id="live-map" style="margin-bottom: 40px; height: 500px"></div>

            <!-- Nearby Listings Grid -->
            <h2 class="mb-4">Recent Listings Nearby</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px">
                
                <!-- Listing Card 1 -->
                <div class="card">
                    <img src="assets/img/bakery.png" class="category-img" alt="Bakery Items">
                    <div class="flex justify-between items-center mb-2">
                        <h3 style="font-size: 1.2rem">Morning Pastries</h3>
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold">0.5 mi</span>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-light); margin-bottom: 15px">
                        A fresh batch of croissants and bagels from Downtown Bakery. Still warm and ready for pickup.
                    </p>
                    <div class="flex justify-between items-center">
                        <span style="font-size: 0.8rem; font-weight: bold; color: var(--secondary-color)">Expires in 45m</span>
                        <button class="btn btn-primary" onclick="window.showToast('Please login to claim')">Claim Now</button>
                    </div>
                </div>

                <!-- Listing Card 2 -->
                <div class="card">
                    <img src="assets/img/produce.png" class="category-img" alt="Fresh Produce">
                    <div class="flex justify-between items-center mb-2">
                        <h3 style="font-size: 1.2rem">Fresh Veggies</h3>
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold">1.2 mi</span>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-light); margin-bottom: 15px">
                        Mixed bag of organic vegetables including carrots, spinach, and tomatoes. High nutritional value.
                    </p>
                    <div class="flex justify-between items-center">
                        <span style="font-size: 0.8rem; font-weight: bold; color: var(--secondary-color)">Expires in 2h</span>
                        <button class="btn btn-primary" onclick="window.showToast('Please login to claim')">Claim Now</button>
                    </div>
                </div>

                <!-- Listing Card 3 -->
                <div class="card">
                    <img src="assets/img/meals.png" class="category-img" alt="Prepared Meals">
                    <div class="flex justify-between items-center mb-2">
                        <h3 style="font-size: 1.2rem">Nutritious Meals</h3>
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold">2.5 mi</span>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--text-light); margin-bottom: 15px">
                        5 portions of grilled chicken and healthy grains. Packaged in sanitized, eco-friendly boxes.
                    </p>
                    <div class="flex justify-between items-center">
                        <span style="font-size: 0.8rem; font-weight: bold; color: var(--secondary-color)">Expires in 4h</span>
                        <button class="btn btn-primary" onclick="window.showToast('Please login to claim')">Claim Now</button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #fff; border-top: 1px solid #ddd; padding: 40px 0; text-align: center; margin-top: 60px">
        <div class="container">
            <p style="font-weight: bold; color: var(--primary-color)">FoodCycle Platform &copy; 2026</p>
            <p style="font-size: 12px; color: #888">A Community Food Rescue Initiative</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    
    <script>
        // Initialize Live Map
        // We set the view to a central location (e.g., London or a local area)
        const map = L.map('live-map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Simulated Marker for Bakery
        L.marker([51.505, -0.09]).addTo(map)
            .bindPopup('<strong>Downtown Bakery</strong><br>3 batches available.')
            .openPopup();

        // Simulated Marker for Supermarket
        L.marker([51.515, -0.1]).addTo(map)
            .bindPopup('<strong>City Supermarket</strong><br>Fresh produce collection.');

        // Marker for a Community Center
        L.marker([51.495, -0.08]).addTo(map)
            .bindPopup('<strong>Hope Shelter</strong><br>Pickup point.');
    </script>
</body>
</html>