<?php 
/*
   User Profile Settings
   Update account identity, contact details, and security.
*/
require_once '../backend/init.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../backend/db.php';
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - My Account</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .profile-wrapper {
            max-width: 800px;
            margin: 40px auto;
        }
        .section-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="profile-wrapper">
                <h1 style="margin-bottom: 40px; text-align: center">Account Settings</h1>

                <!-- Profile Identity Section -->
                <div class="card mb-4" style="padding: 30px">
                    <h3 class="section-header">
                        <i data-icon="user" class="icon"></i> Personal Identity
                    </h3>
                    <form action="../backend/api_profile.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_profile">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px">
                            <!-- Avatar Upload -->
                            <div style="text-align: center">
                                <div style="width: 150px; height: 150px; background: #eee; border-radius: 50%; margin: 0 auto 15px; overflow: hidden; border: 4px solid var(--white); box-shadow: var(--shadow)">
                                    <?php if ($user['profile_image']): ?>
                                        <img src="<?php echo $user['profile_image']; ?>" style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size: 3rem">
                                            <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="avatar" style="display: none" id="avatar-input">
                                <button type="button" class="btn btn-outline" style="font-size: 11px" onclick="document.getElementById('avatar-input').click()">Change Photo</button>
                            </div>

                            <!-- Identity Details -->
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Primary Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 30px; text-align: right">
                            <button type="submit" class="btn btn-primary" style="padding: 10px 40px">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Logistics Section -->
                <div class="card mb-4" style="padding: 30px">
                    <h3 class="section-header">
                        <i data-icon="truck" class="icon"></i> Operational Details
                    </h3>
                    <form action="../backend/api_profile.php" method="POST">
                        <input type="hidden" name="action" value="update_logistics">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="form-group">
                            <label class="form-label">Contact Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pickup/Office Address</label>
                            <textarea name="address" class="form-control" style="height: 80px" placeholder="Street, City, Zip Code"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>

                        <div style="margin-top: 30px; text-align: right">
                            <button type="submit" class="btn btn-primary" style="padding: 10px 40px">Update Logistics</button>
                        </div>
                    </form>
                </div>

                <!-- Security Section -->
                <div class="card" style="padding: 30px">
                    <h3 class="section-header" style="color: #c62828">
                        <i data-icon="shield" class="icon"></i> Security & Passcode
                    </h3>
                    <form action="../backend/api_profile.php" method="POST">
                        <input type="hidden" name="action" value="update_password">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="form-group">
                            <label class="form-label">Current Passcode</label>
                            <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Passcode</label>
                            <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                        </div>

                        <div style="margin-top: 30px; text-align: right">
                            <button type="submit" class="btn btn-secondary" style="padding: 10px 40px">Rotate Passcode</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Account Management &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>