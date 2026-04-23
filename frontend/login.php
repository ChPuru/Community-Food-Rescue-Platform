<?php 
/*
   Login Account
   Secure authentication page for FoodCycle operators.
*/
require_once '../backend/init.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Login</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .auth-container {
            max-width: 450px;
            margin: 100px auto;
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
                    <i data-icon="recycle" class="icon" style="width:32px;height:32px"></i>
                    FoodCycle
                </div>
                <h2 style="font-size: 1.5rem">Welcome Back</h2>
                <p style="color: #666; font-size: 0.9rem">Please enter your credentials to access the platform.</p>
            </div>

            <form action="../backend/api_login.php" method="POST">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Passcode (Password)</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div style="margin-bottom: 25px">
                    <label style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; cursor: pointer">
                        <input type="checkbox" name="remember" style="width: 18px; height: 18px">
                        Keep me logged in for 30 days
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px">Access Dashboard</button>
            </form>

            <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #eee">
                <p style="font-size: 0.9rem; color: #666">
                    Don't have an account yet? <br>
                    <a href="register.php" style="color: var(--primary-color); font-weight: 700">Register as a Donor or NGO</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>