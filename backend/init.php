<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

try {
    $check = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount();
    if ($check == 0) {
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('donor', 'ngo', 'recipient') NOT NULL DEFAULT 'donor',
            phone VARCHAR(20) DEFAULT NULL,
            address TEXT DEFAULT NULL,
            profile_image VARCHAR(255) DEFAULT NULL,
            remember_token VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");

        $pdo->exec("CREATE TABLE IF NOT EXISTS listings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            category VARCHAR(100) NOT NULL,
            quantity INT NOT NULL,
            description TEXT,
            image_path VARCHAR(255) DEFAULT NULL,
            latitude DECIMAL(10, 8) DEFAULT NULL,
            longitude DECIMAL(11, 8) DEFAULT NULL,
            available_until DATETIME NOT NULL,
            status ENUM('active', 'claimed', 'expired') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );");

        $pdo->exec("CREATE TABLE IF NOT EXISTS claims (
            id INT AUTO_INCREMENT PRIMARY KEY,
            listing_id INT NOT NULL,
            user_id INT NOT NULL,
            claimed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
            FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );");

        $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            type VARCHAR(50) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            body TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
            sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );");
    }
} catch (PDOException $e) {}

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
    }
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';

if (!defined('API_REQUEST')) {
    echo '<script>';
    echo 'window.USER_ROLE = "' . htmlspecialchars($role) . '"; ';
    echo 'window.USER_ID = ' . $userId . '; ';
    echo 'window.USER_NAME = "' . htmlspecialchars($userName) . '"; ';
    echo 'window.CSRF_TOKEN = "' . $_SESSION['csrf_token'] . '";';
    echo '</script>';
}
