<?php
/**
 * FoodCycle - Login API Handler
 * Authenticates users and manages sessions/cookies.
 */
define('API_REQUEST', true);
require_once 'init.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Basic CSRF Verification
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: ../frontend/login.php?error=csrf");
        exit;
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // 2. Fetch User
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // 3. Success - Set Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // 4. Handle "Remember Me"
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);
            
            // Set cookie for 30 days
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
        }

        header("Location: ../frontend/dashboard.php");
        exit;
    } else {
        // 5. Failure
        header("Location: ../frontend/login.php?error=invalid");
        exit;
    }
} else {
    header("Location: ../frontend/login.php");
    exit;
}