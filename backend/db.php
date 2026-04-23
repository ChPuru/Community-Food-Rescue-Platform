<?php

$host = 'localhost';
$dbname = 'foodcycle';
$username = 'root';

$possible_passwords = ['', 'root', 'password', '123456', '12345678', 'mysql'];

$pdo = null;
$connected = false;
$last_error = "";

foreach ($possible_passwords as $pwd) {
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $pwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $pdo->exec("USE `$dbname`;");
        
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $connected = true;
        break;
    } catch (PDOException $e) {
        $last_error = $e->getMessage();
        continue;
    }
}

if (!$connected) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Database Setup Required</title>
        <style>
            body { font-family: 'Inter', sans-serif; background: #f4f7f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .setup-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 500px; text-align: center; }
            h1 { color: #2e7d32; margin-bottom: 10px; }
            p { color: #666; line-height: 1.6; }
            .error-box { background: #ffebee; color: #c62828; padding: 15px; border-radius: 6px; font-size: 0.85rem; margin: 20px 0; text-align: left; border: 1px solid #ffcdd2; }
            code { background: #eee; padding: 2px 5px; border-radius: 3px; }
        </style>
    </head>
    <body>
        <div class="setup-card">
            <h1>🛠️ Database Connection Required</h1>
            <p>We tried common passwords but your teammate's computer has a custom MySQL setup.</p>
            
            <div class="error-box">
                <strong>Current Error:</strong><br>
                <?php echo htmlspecialchars($last_error); ?>
            </div>

            <p style="font-weight: bold; color: #333;">How to fix this for your presentation:</p>
            <ol style="text-align: left; color: #555;">
                <li>Open <code>backend/db.php</code> in VS Code.</li>
                <li>Find the <code>$possible_passwords</code> array on line 7.</li>
                <li>Add your teammate's MySQL password to that list.</li>
                <li>Save and refresh this page.</li>
            </ol>
            
            <p style="font-size: 0.8rem; color: #999;">Tip: Usually the password can be found in the "User accounts" tab of phpMyAdmin.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}
