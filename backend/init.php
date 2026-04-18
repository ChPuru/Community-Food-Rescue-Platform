<?php
session_start();
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    require_once 'db.php';
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
    }
}
?>

