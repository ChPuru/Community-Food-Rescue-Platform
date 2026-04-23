<?php 
/*
   Project Impact Analytics
   Visualizing the platform's contribution to food waste reduction.
*/
require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Project Impact</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <h1 style="text-align: center; color: var(--primary-color); font-size: 3rem; margin-bottom: 10px">Community Impact</h1>
            <p style="text-align: center; color: #666; margin-bottom: 50px">Tracking our progress in reducing food waste and supporting local nutritional needs.</p>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 60px">
                <!-- Meals Card -->
                <div class="card" style="text-align: center; padding: 40px; border-top: 4px solid var(--accent-color)">
                    <i data-icon="coffee" style="width: 48px; height: 48px; color: var(--accent-color); margin-bottom: 20px"></i>
                    <h2 id="impact-meals" style="font-size: 2.5rem; margin-bottom: 5px">--</h2>
                    <p style="text-transform: uppercase; font-size: 0.75rem; font-weight: bold; color: #888; letter-spacing: 1px">Meals Rescued</p>
                </div>

                <!-- CO2 Card -->
                <div class="card" style="text-align: center; padding: 40px; border-top: 4px solid var(--secondary-color)">
                    <i data-icon="wind" style="width: 48px; height: 48px; color: var(--secondary-color); margin-bottom: 20px"></i>
                    <h2 id="impact-co2" style="font-size: 2.5rem; margin-bottom: 5px">--</h2>
                    <p style="text-transform: uppercase; font-size: 0.75rem; font-weight: bold; color: #888; letter-spacing: 1px">CO2 Reduced (kg)</p>
                </div>

                <!-- Families Card -->
                <div class="card" style="text-align: center; padding: 40px; border-top: 4px solid var(--primary-color)">
                    <i data-icon="users" style="width: 48px; height: 48px; color: var(--primary-color); margin-bottom: 20px"></i>
                    <h2 id="impact-families" style="font-size: 2.5rem; margin-bottom: 5px">--</h2>
                    <p style="text-transform: uppercase; font-size: 0.75rem; font-weight: bold; color: #888; letter-spacing: 1px">Organizations Helped</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px">
                <div>
                    <h2 class="mb-4">Our Calculation Methodology</h2>
                    <p style="color: #555; line-height: 1.8; margin-bottom: 20px">
                        We calculate our CO2 impact based on the weight of food rescued. For every kilogram of food diverted from landfills, we estimate a reduction of approximately 2.5kg of CO2 equivalent emissions.
                    </p>
                    <p style="color: #555; line-height: 1.8">
                        Our "Meals Saved" metric is derived from the standard portion size of 400g per meal. This data helps us visualize the tangible benefit our platform provides to the community.
                    </p>
                </div>
                <div class="card" style="background: var(--primary-color); color: white; padding: 30px">
                    <h3 class="mb-4">Environmental Goals</h3>
                    <ul style="list-style: none; line-height: 2.5">
                        <li style="display: flex; align-items: center; gap: 10px"><i data-icon="check-circle" style="width:16px;height:16px"></i> Reduce local landfill waste by 15%</li>
                        <li style="display: flex; align-items: center; gap: 10px"><i data-icon="check-circle" style="width:16px;height:16px"></i> Partner with 50+ local grocery stores</li>
                        <li style="display: flex; align-items: center; gap: 10px"><i data-icon="check-circle" style="width:16px;height:16px"></i> Achieve Zero-Waste status for local events</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <footer style="margin-top: 80px; text-align: center; padding: 40px; border-top: 1px solid #eee; color: #888">
        FoodCycle Community Impact Report &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../backend/api_stats.php')
                .then(r => r.json())
                .then(d => {
                    if(d.status === 'success') {
                        document.getElementById('impact-meals').textContent = d.global.meals_saved.toLocaleString();
                        document.getElementById('impact-co2').textContent = d.global.co2_reduced.toLocaleString();
                        document.getElementById('impact-families').textContent = d.global.families_helped.toLocaleString();
                    }
                });
        });
    </script>
</body>
</html>