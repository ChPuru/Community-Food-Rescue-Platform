<?php 
/*
   Impact Dashboard
   Visualizing the ecological and community reach of FoodCycle.
   // Academic Lab Submission (Unit 4 Final Project)
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
            <div style="text-align: center; margin-bottom: 60px">
                <h1 style="font-size: 3rem; color: var(--primary-color)">Community Impact</h1>
                <p style="color: #666; max-width: 600px; margin: 0 auto">
                    Tracking our progress in reducing food waste and supporting local nutritional needs.
                </p>
            </div>

            <!-- Key Metrics Grid -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 60px">
                <div class="card text-center" style="padding: 40px">
                    <i data-icon="coffee" style="width: 50px; height: 50px; color: var(--accent-color); margin-bottom: 10px"></i>
                    <h3 style="font-size: 2.5rem; color: var(--primary-color)">2,450</h3>
                    <p style="font-weight: bold; text-transform: uppercase; font-size: 0.8rem; color: #888">Meals Rescued</p>
                </div>
                <div class="card text-center" style="padding: 40px">
                    <i data-icon="wind" style="width: 50px; height: 50px; color: var(--secondary-color); margin-bottom: 10px"></i>
                    <h3 style="font-size: 2.5rem; color: var(--primary-color)">1.8<span style="font-size: 1rem">t</span></h3>
                    <p style="font-weight: bold; text-transform: uppercase; font-size: 0.8rem; color: #888">CO2 Reduced</p>
                </div>
                <div class="card text-center" style="padding: 40px">
                    <i data-icon="users" style="width: 50px; height: 50px; color: var(--primary-color); margin-bottom: 10px"></i>
                    <h3 style="font-size: 2.5rem; color: var(--primary-color)">125</h3>
                    <p style="font-weight: bold; text-transform: uppercase; font-size: 0.8rem; color: #888">Families Helped</p>
                </div>
            </div>

            <!-- Detailed Methodology -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center">
                <div>
                    <h2 style="margin-bottom: 20px">Our Calculation Methodology</h2>
                    <p style="margin-bottom: 15px; color: #555">
                        We calculate our CO2 impact based on the weight of food rescued. For every kilogram of food diverted from landfills, we estimate a reduction of approximately 2.5kg of CO2 equivalent emissions.
                    </p>
                    <p style="color: #555">
                        Our "Meals Saved" metric is derived from the standard portion size of 400g per meal. This data helps us visualize the tangible benefit our platform provides to the community.
                    </p>
                </div>
                <div class="card" style="background: var(--primary-color); color: white">
                    <h3 style="font-family: 'Lora', serif">Environmental Goals</h3>
                    <ul style="margin-top: 20px; list-style: none">
                        <li style="margin-bottom: 10px; display: flex; align-items: flex-start; gap: 10px">
                            <span style="opacity: 0.8">•</span> Reduce local landfill waste by 15%
                        </li>
                        <li style="margin-bottom: 10px; display: flex; align-items: flex-start; gap: 10px">
                            <span style="opacity: 0.8">•</span> Partner with 50+ local grocery stores
                        </li>
                        <li style="margin-bottom: 10px; display: flex; align-items: flex-start; gap: 10px">
                            <span style="opacity: 0.8">•</span> Achieve Zero-Waste status for local events
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <footer style="margin-top: 60px; text-align: center; padding: 40px; border-top: 1px solid #eee">
        <p style="color: #999; font-size: 0.8rem">Project Methodology & Data Analytics &copy; 2026</p>
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>