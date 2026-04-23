<?php 
/*
   Live Feed of Food Donations
   Available Donations Feed
   Real-time view of active rescue batches.
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
            <div style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 40px">
                <h1 style="font-size: 2.8rem; color: var(--primary-color)">Available Donations</h1>
                <p style="color: #666">View active food rescue batches available for immediate pickup in your community.</p>
            </div>

            <!-- Feed Content -->
            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 40px">
                
                <!-- Main Feed List -->
                <section>
                    <div id="feed-container" style="display: grid; grid-template-columns: 1fr; gap: 20px">
                        <!-- JS will populate this with standard cards -->
                        <div class="skeleton" style="height: 200px"></div>
                        <div class="skeleton" style="height: 200px"></div>
                        <div class="skeleton" style="height: 200px"></div>
                    </div>
                </section>

                <!-- Sidebar Info / Stats -->
                <aside>
                    <div class="card mb-4">
                        <h4 style="margin-bottom: 15px; border-bottom: 1.5px solid #eee; padding-bottom: 8px">Project Statistics</h4>
                        <ul style="list-style: none; font-size: 0.9rem; color: #555; line-height: 2">
                            <li>Active Batches: 12</li>
                            <li>Registered Donors: 8</li>
                            <li>Rescue Centers: 5</li>
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
        // Adjusting feed for traditional look
        document.addEventListener('DOMContentLoaded', () => {
            // Need to make sure the JS feed items use standard card styles
            // The existing feed.js will handle rendering, but I'll add a hover effect here
        });
    </script>
</body>
</html>