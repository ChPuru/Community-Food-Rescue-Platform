<?php 

require_once '../backend/init.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
if (!$stmt->fetch()) {
    header("Location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container dashboard-container">
                
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 style="font-size: 2.2rem; color: var(--primary-color)">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                            <p style="color: #666">Here is your current impact and activity overview.</p>
                        </div>
                        <span style="font-weight: bold; background: #e8f5e9; color: #2e7d32; padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; border: 1px solid #c8e6c9">
                            ROLE: <?php echo strtoupper($role); ?>
                        </span>
                    </div>

                    <!-- Stats Row -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 40px">
                        <div class="card" style="border-top: 5px solid var(--primary-color); text-align: center; padding: 30px">
                            <p style="color: #888; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; letter-spacing: 1px">Batches Helped</p>
                            <h3 id="stat-batches" style="font-size: 2.8rem; margin-top: 10px">--</h3>
                        </div>
                        <div class="card" style="border-top: 5px solid var(--secondary-color); text-align: center; padding: 30px">
                            <p style="color: #888; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; letter-spacing: 1px">Impact Score</p>
                            <h3 id="stat-impact" style="font-size: 2.8rem; margin-top: 10px">--</h3>
                        </div>
                        <div class="card" style="border-top: 5px solid var(--accent-color); text-align: center; padding: 30px">
                            <p style="color: #888; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; letter-spacing: 1px">Active Claims</p>
                            <h3 id="stat-active" style="font-size: 2.8rem; margin-top: 10px">--</h3>
                        </div>
                    </div>

                    <!-- Recent Activity Table -->
                    <div class="card" style="padding: 30px">
                        <div class="flex justify-between items-center mb-4">
                            <h4 style="font-size: 1.2rem">Recent Activity Overview</h4>
                            <a href="feed.php" class="btn btn-outline" style="font-size: 11px">Browse More Food</a>
                        </div>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem">
                            <thead>
                                <tr style="text-align: left; border-bottom: 2px solid #eee">
                                    <th style="padding: 15px">Date</th>
                                    <th style="padding: 15px">Action</th>
                                    <th style="padding: 15px">Status</th>
                                </tr>
                            </thead>
                            <tbody id="activity-table-body">
                                <tr>
                                    <td colspan="3" style="padding: 30px; text-align: center; color: #888">Loading your activity...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

        </div>
    </main>

    <footer style="text-align:center; padding:40px; color:#888; font-size: 0.8rem">
        FoodCycle Portal &copy; 2026 - Educational Lab Project
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../backend/api_stats.php')
                .then(r => r.json())
                .then(d => {
                    if(d.status === 'success') {
                        document.getElementById('stat-batches').textContent = d.user.batches_helped;
                        document.getElementById('stat-impact').textContent = d.user.impact_score;
                        document.getElementById('stat-active').textContent = d.user.active_claims;

                        const tableBody = document.getElementById('activity-table-body');
                        if(d.user.recent_activity.length > 0) {
                            tableBody.innerHTML = d.user.recent_activity.map(a => `
                                <tr style="border-bottom: 1px solid #f9f9f9">
                                    <td style="padding: 15px; color: #666">${new Date(a.date).toLocaleDateString()}</td>
                                    <td style="padding: 15px; font-weight: 500">${a.action}</td>
                                    <td style="padding: 15px">
                                        <span style="font-weight: bold; font-size: 11px; padding: 4px 10px; border-radius: 4px; background: ${a.status === 'claimed' ? '#e8f5e9' : '#fff3e0'}; color: ${a.status === 'claimed' ? '#2e7d32' : '#ef6c00'}">
                                            ${a.status.toUpperCase()}
                                        </span>
                                    </td>
                                </tr>
                            `).join('');
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="3" style="padding: 30px; text-align: center; color: #888">No recent activity found. Start participating to see your impact!</td></tr>';
                        }
                    }
                });
        });
    </script>
</body>
</html>
