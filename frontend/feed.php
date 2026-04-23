<?php 
/*
   Live Feed of Food Donations
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

    <main class="content-area">
        <div class="container">
            <!-- Header Section -->
            <div style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end">
                <div>
                    <h1 style="font-size: 2.8rem; color: var(--primary-color)">Available Donations</h1>
                    <p style="color: #666">View active food rescue batches available for immediate pickup in your community.</p>
                </div>
                <div style="font-size: 0.75rem; font-weight: bold; text-transform: uppercase; color: #888; background: #f5f5f5; padding: 4px 12px; border-radius: 50px; display: flex; align-items: center; gap: 6px">
                    <span style="width: 8px; height: 8px; background: #4caf50; border-radius: 50%"></span>
                    Status: <span id="feed-update-status">Live</span>
                </div>
            </div>

            <!-- Feed Content -->
            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 40px">
                
                <!-- Main Feed List -->
                <section>
                    <div id="feed-container" style="display: grid; grid-template-columns: 1fr; gap: 20px">
                        <!-- JS will populate this -->
                        <div class="skeleton" style="height: 200px"></div>
                        <div class="skeleton" style="height: 200px"></div>
                    </div>
                </section>

                <!-- Sidebar Info / Stats -->
                <aside>
                    <div class="card mb-4">
                        <h4 style="margin-bottom: 15px; border-bottom: 1.5px solid #eee; padding-bottom: 8px">Project Statistics</h4>
                        <ul style="list-style: none; font-size: 0.9rem; color: #555; line-height: 2">
                            <li>Active Batches: <span id="sidebar-stat-active" style="font-weight:bold">--</span></li>
                            <li>Registered Users: <span id="sidebar-stat-users" style="font-weight:bold">--</span></li>
                            <li>Total Rescues: <span id="sidebar-stat-claims" style="font-weight:bold">--</span></li>
                        </ul>
                    </div>

                    <div class="card" style="background: var(--primary-color); color: white">
                        <h4 style="margin-bottom: 10px">Need Assistance?</h4>
                        <p style="font-size: 0.8rem; margin-bottom: 15px">If you are a representative of an NGO and need help claiming batches, contact us.</p>
                        <a href="feedback.php" class="btn btn-secondary" style="width: 100%; text-align: center">Contact Support</a>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <footer style="background: #fff; border-top: 1px solid #ddd; padding: 40px 0; text-align: center; margin-top: 60px">
        <div class="container">
            <p style="font-weight: bold; color: var(--primary-color)">FoodCycle Platform &copy; 2026</p>
            <p style="font-size: 12px; color: #888">Final Lab Project Submission</p>
        </div>
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    <script src="assets/feed.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../backend/api_stats.php')
                .then(r => r.json())
                .then(d => {
                    if(d.status === 'success') {
                        document.getElementById('sidebar-stat-active').textContent = d.global.active_listings;
                        document.getElementById('sidebar-stat-users').textContent = d.global.total_users;
                        document.getElementById('sidebar-stat-claims').textContent = d.global.total_claims;
                    }
                });
        });
    </script>
</body>
</html>