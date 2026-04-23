<?php 

require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Join Movement</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .auth-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
        }
    </style>
</head>
<body style="background-color: #f0f2f5">
    <div id="header-placeholder"></div>

    <div class="container">
        <div class="card auth-container">
            <div style="text-align: center; margin-bottom: 30px">
                <div class="logo justify-center mb-2">
                    <i data-icon="user-plus" class="icon" style="width:32px;height:32px"></i>
                    Join FoodCycle
                </div>
                <h2 style="font-size: 1.5rem">Create Your Account</h2>
                <p style="color: #666; font-size: 0.9rem">Select your operational role to get started.</p>
            </div>

            <form action="../backend/api_register.php" method="POST">
                <div class="flex gap-4 mb-4">
                    <label class="flex-1 card text-center" style="cursor: pointer; padding: 15px; transition: 0.2s" id="role-donor-card">
                        <input type="radio" name="role" value="donor" checked style="margin-bottom: 10px">
                        <div style="font-weight: bold">FOOD DONOR</div>
                        <div style="font-size: 10px; color: #888">Restaurants, Markets</div>
                    </label>
                    <label class="flex-1 card text-center" style="cursor: pointer; padding: 15px; transition: 0.2s" id="role-ngo-card">
                        <input type="radio" name="role" value="ngo" style="margin-bottom: 10px">
                        <div style="font-weight: bold">RESCUE NGO</div>
                        <div style="font-size: 10px; color: #888">Shelters, Charities</div>
                    </label>
                    <label class="flex-1 card text-center" style="cursor: pointer; padding: 15px; transition: 0.2s" id="role-recipient-card">
                        <input type="radio" name="role" value="recipient" style="margin-bottom: 10px">
                        <div style="font-weight: bold">RECIPIENT</div>
                        <div style="font-size: 10px; color: #888">Individual/Families</div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name / Organization Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Hope Shelter or John Doe" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="contact@domain.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Create Passcode (Password)</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Passcode</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; margin-top: 20px">Finalize Registration</button>
            </form>

            <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #eee">
                <p style="font-size: 0.9rem; color: #666">
                    Already an active member? <br>
                    <a href="login.php" style="color: var(--secondary-color); font-weight: 700">Access your Dashboard</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>
