<?php 
/*
   FoodCycle Project - Index / Landing Page
   Academic Submission Version
   Developed for Web Programming Lab
*/
require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Community Food Rescue Platform</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main>
        <!-- Hero Banner - Traditional responsive container -->
        <section class="hero-section">
            <div class="container">
                <div style="max-width: 850px; margin: 0 auto">
                    <h1 style="font-size: 3.8rem; margin-bottom: 25px; line-height: 1.1">
                        Saving Food, <span style="color: #a5d6a7">Strengthening Community</span>
                    </h1>
                    <p style="font-size: 1.25rem; margin-bottom: 40px; opacity: 0.9">
                        Our platform connects local food donors with organizations that help people in need. 
                        Let's work together to reduce food waste and help our neighbors.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="feed.php" class="btn btn-primary" style="padding: 15px 35px">Find Food Near Me</a>
                        <a href="new-listing.php" class="btn btn-secondary" style="padding: 15px 35px">Donate Surplus Food</a>
                    </div>
                </div>
            </div>
        </section>

            <!-- Introduction Section -->
            <section style="margin-top: 60px; text-align: center">
                <h2 style="color: var(--primary-color); margin-bottom: 15px">Why FoodCycle?</h2>
                <p style="max-width: 700px; margin: 0 auto; color: #555">
                    Every day, tons of perfectly good food go to waste. At the same time, many people struggle to find their next meal. 
                    FoodCycle is a student-led initiative to bridge this gap using real-time technology.
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 50px">
                    <div class="card">
                        <i data-icon="zap" style="width: 40px; height: 40px; color: var(--accent-color); margin-bottom: 15px"></i>
                        <h3>Real-time Alerts</h3>
                        <p style="font-size: 0.9rem; color: #666; margin-top: 10px">Get notified immediately when a local business lists surplus food.</p>
                    </div>
                    <div class="card">
                        <i data-icon="map-pin" style="width: 40px; height: 40px; color: var(--secondary-color); margin-bottom: 15px"></i>
                        <h3>Interactive Maps</h3>
                        <p style="font-size: 0.9rem; color: #666; margin-top: 10px">Find rescue points and donors easily with our live mapping system.</p>
                    </div>
                    <div class="card">
                        <i data-icon="award" style="width: 40px; height: 40px; color: var(--primary-color); margin-bottom: 15px"></i>
                        <h3>Impact Tracking</h3>
                        <p style="font-size: 0.9rem; color: #666; margin-top: 10px">See how many meals we've saved and the CO2 emissions avoided.</p>
                    </div>
                </div>
            </section>

            <!-- Recent Rescues Section -->
            <section style="margin-top: 80px">
                <div class="flex justify-between items-end mb-4">
                    <h2 style="color: var(--primary-color)">Current Food Batches</h2>
                    <a href="feed.php" style="font-weight: 600; color: var(--secondary-color)">View Full Feed &rarr;</a>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px">
                    <div class="card">
                        <img src="assets/img/bakery.png" class="category-img" alt="Bakery">
                        <h4>Bakery Surplus</h4>
                        <p style="font-size: 0.85rem; color: #666; margin-top: 5px">Fresh breads and muffins from Central Bakery.</p>
                        <a href="feed.php" class="btn btn-outline" style="width: 100%; margin-top: 15px; text-align: center">Check Details</a>
                    </div>
                    <div class="card">
                        <img src="assets/img/produce.png" class="category-img" alt="Produce">
                        <h4>Fresh Produce</h4>
                        <p style="font-size: 0.85rem; color: #666; margin-top: 5px">Assorted fruits and vegetables from organic farm.</p>
                        <a href="feed.php" class="btn btn-outline" style="width: 100%; margin-top: 15px; text-align: center">Check Details</a>
                    </div>
                    <div class="card">
                        <img src="assets/img/meals.png" class="category-img" alt="Meals">
                        <h4>Prepared Meals</h4>
                        <p style="font-size: 0.85rem; color: #666; margin-top: 5px">High-quality catering meals from Hotel Grand.</p>
                        <a href="feed.php" class="btn btn-outline" style="width: 100%; margin-top: 15px; text-align: center">Check Details</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #fff; border-top: 1px solid #ddd; padding: 60px 0; margin-top: 100px">
        <div class="container" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 50px">
            <div>
                <div class="logo">
                    <i data-icon="recycle" class="icon" style="width:24px;height:24px"></i>
                    FoodCycle
                </div>
                <p style="margin-top: 15px; color: #666; font-size: 0.9rem">
                    A web-based platform dedicated to reducing food waste and supporting local hunger relief efforts through smart logistics.
                </p>
            </div>
            <div>
                <h4 style="margin-bottom: 20px">Quick Links</h4>
                <ul style="list-style: none; font-size: 0.9rem; color: #444; line-height: 2">
                    <li><a href="feed.php">Donation Feed</a></li>
                    <li><a href="nearby.php">Nearby Map</a></li>
                    <li><a href="impact.php">Our Impact</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 20px">Contact Details</h4>
                <ul style="list-style: none; font-size: 0.9rem; color: #444; line-height: 2">
                    <li>Email: students@lab.college.edu</li>
                    <li>Location: Web Programming Lab</li>
                </ul>
            </div>
        </div>
        <div class="container" style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee">
            <p style="font-size: 13px; color: #999">FoodCycle &copy; 2026 - Mini Project Submission</p>
        </div>
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>