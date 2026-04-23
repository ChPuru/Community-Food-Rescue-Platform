<?php 

require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Pickup Protocol</title>
    <link rel="stylesheet" href="assets/assets/styles.css"> <!-- checking path -->
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container" style="max-width: 900px">
            <h1 style="color: var(--primary-color); margin-bottom: 20px; text-align: center">Pickup & Safety Protocol</h1>
            
            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; margin-top: 40px">
                
                <!-- Guidelines -->
                <section>
                    <div class="card mb-4" style="padding: 30px">
                        <h3 style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px">
                            <i data-icon="shield-check" class="icon" style="color: var(--primary-color)"></i>
                            Food Safety Guidelines
                        </h3>
                        <ul style="padding-left: 20px; color: #444; line-height: 1.8">
                            <li>Ensure all temperature-sensitive items (Dairy/Meals) are transported in insulated bags.</li>
                            <li>Verify the "Best Before" date upon arrival at the donor location.</li>
                            <li>Personnel must wear clean gloves and masks during the handoff.</li>
                            <li>If packaging is compromised, do not proceed with the rescue.</li>
                        </ul>
                    </div>

                    <div class="card" style="padding: 30px">
                        <h3 style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px">
                            <i data-icon="info" class="icon" style="color: var(--secondary-color)"></i>
                            Logistics Workflow
                        </h3>
                        <ol style="padding-left: 20px; color: #444; line-height: 1.8">
                            <li>Notify the donor using the platform contact details.</li>
                            <li>Arrive at the designated pickup point with the Batch ID.</li>
                            <li>Confirm quantity and quality with the donor representative.</li>
                            <li>Mark the rescue as "Delivered" on your dashboard.</li>
                        </ol>
                    </div>
                </section>

                <!-- Status / Tracking Card -->
                <aside>
                    <div class="card text-center" style="background: #f8f9fa; border: 2px dashed var(--primary-color)">
                        <i data-icon="clock" style="width: 40px; height: 40px; margin-bottom: 15px; color: var(--accent-color)"></i>
                        <h4>Active Rescues</h4>
                        <p style="font-size: 0.8rem; color: #666; margin-top: 5px">You currently have 2 pending pickups.</p>
                        <div style="margin-top: 20px; text-align: left; background: white; padding: 10px; border-radius: 6px; font-size: 0.75rem">
                            <strong>Batch #4502</strong><br>
                            <span style="color: var(--primary-color)">Ready for collection</span>
                        </div>
                    </div>

                    <div class="card mt-4" style="text-align: center">
                        <button class="btn btn-primary" style="width: 100%">Download PDF Instructions</button>
                    </div>
                </aside>

            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Logistics &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>
