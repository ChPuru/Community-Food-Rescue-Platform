<?php
error_reporting(0);
ini_set('display_errors', 0);

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
    if (defined('API_REQUEST')) {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'error', 'message' => 'Database connection failed. Please check backend/db.php.']));
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Database Setup Required</title>
        <style>
            body { font-family: sans-serif; background: #f4f7f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .setup-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 500px; text-align: center; }
            h1 { color: #2e7d32; }
            .error-box { background: #ffebee; color: #c62828; padding: 15px; border-radius: 6px; font-size: 0.85rem; margin: 20px 0; text-align: left; border: 1px solid #ffcdd2; }
        </style>
    </head>
    <body>
        <div class="setup-card">
            <h1>🛠️ Database Connection Required</h1>
            <p>We tried common passwords but your teammate's computer has a custom MySQL setup.</p>
            <div class="error-box"><strong>Error:</strong> <?php echo htmlspecialchars($last_error); ?></div>
            <p>Please open <code>backend/db.php</code> and update <code>$possible_passwords</code> on line 10.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}
