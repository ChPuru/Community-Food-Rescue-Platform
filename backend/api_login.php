<?php

define('API_REQUEST', true);
require_once 'init.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: ../frontend/login.php?error=csrf");
        exit;
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);

            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
        }

        header("Location: ../frontend/dashboard.php");
        exit;
    } else {
        
        header("Location: ../frontend/login.php?error=invalid");
        exit;
    }
} else {
    header("Location: ../frontend/login.php");
    exit;
}
