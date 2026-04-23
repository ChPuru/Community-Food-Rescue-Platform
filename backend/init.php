<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    require_once 'db.php';
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

echo '<script>';
echo 'window.USER_ROLE = "' . htmlspecialchars($role) . '"; ';
echo 'window.USER_ID = ' . $userId . '; ';
echo 'window.USER_NAME = "' . htmlspecialchars($userName) . '"; ';
echo 'window.CSRF_TOKEN = "' . $_SESSION['csrf_token'] . '";';
echo '</script>';
// No closing tag to avoid quirks mode issues