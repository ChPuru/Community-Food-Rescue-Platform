<?php 
/*
   Operator Dashboard
   This page provides an overview of rescues and listings.
   Uses a traditional sidebar-based administrative layout.
*/
require_once '../backend/init.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="dashboard-layout">
                
                <!-- Sidebar Navigation -->
                <aside class="sidebar card">
                    <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--primary-color)">Menu</h3>
                    <nav>
                        <a href="dashboard.php" class="sidebar-link active">
                            <i data-icon="layout" class="icon"></i> Overview
                        </a>
                        <a href="feed.php" class="sidebar-link">
                            <i data-icon="list" class="icon"></i> Browse Food
                        </a>
                        <a href="nearby.php" class="sidebar-link">
                            <i data-icon="map" class="icon"></i> Near Me
                        </a>
                        <?php if ($role === 'donor'): ?>
                        <a href="new-listing.php" class="sidebar-link">
                            <i data-icon="plus-circle" class="icon"></i> Add Listing
                        </a>
                        <?php endif; ?>
                        <a href="profile.php" class="sidebar-link">
                            <i data-icon="user" class="icon"></i> My Profile
                        </a>
                        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee">
                            <a href="logout.php" class="sidebar-link" style="color: #c62828">
                                <i data-icon="log-out" class="icon"></i> Logout Account
                            </a>
                        </div>
                    </nav>
                </aside>

                <!-- Dashboard Content -->
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                        <span style="font-weight: bold; background: var(--bg-color); padding: 5px 15px; border-radius: 50px; font-size: 0.8rem">
                            Status: <?php echo strtoupper($role); ?>
                        </span>
                    </div>

                    <!-- Stats Row -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px">
                        <div class="card" style="border-left: 5px solid var(--primary-color)">
                            <p style="color: #888; font-size: 0.8rem; font-weight: bold">BATCHES HELPED</p>
                            <h3 style="font-size: 2rem">24</h3>
                        </div>
                        <div class="card" style="border-left: 5px solid var(--secondary-color)">
                            <p style="color: #888; font-size: 0.8rem; font-weight: bold">IMPACT SCORE</p>
                            <h3 style="font-size: 2rem">850</h3>
                        </div>
                        <div class="card" style="border-left: 5px solid var(--accent-color)">
                            <p style="color: #888; font-size: 0.8rem; font-weight: bold">ACTIVE CLAIMS</p>
                            <h3 style="font-size: 2rem">2</h3>
                        </div>
                    </div>

                    <!-- Recent Activity Table -->
                    <div class="card">
                        <h4 style="margin-bottom: 15px">Recent Activity Overview</h4>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem">
                            <thead>
                                <tr style="text-align: left; border-bottom: 2px solid #eee">
                                    <th style="padding: 12px">Date</th>
                                    <th style="padding: 12px">Action</th>
                                    <th style="padding: 12px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #f5f5f5">
                                    <td style="padding: 12px">Apr 22, 2026</td>
                                    <td style="padding: 12px">Claimed "Organic Veggie Box"</td>
                                    <td style="padding: 12px; color: green; font-weight: bold">Complete</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f5f5f5">
                                    <td style="padding: 12px">Apr 21, 2026</td>
                                    <td style="padding: 12px">Listing created "Bakery Surplus"</td>
                                    <td style="padding: 12px; color: #888">Verified</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px">Apr 20, 2026</td>
                                    <td style="padding: 12px">Profile updated</td>
                                    <td style="padding: 12px; color: green; font-weight: bold">Success</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <footer style="text-align:center; padding:40px; color:#888; font-size: 0.8rem">
        FoodCycle Dashboard &copy; 2026 - Educational Lab Project
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>