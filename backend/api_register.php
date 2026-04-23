<?php
/**
 * FoodCycle - Registration API Handler
 * Handles new user onboarding and security hashing.
 */
define('API_REQUEST', true);
require_once 'init.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // 1. Basic Validation
    if ($password !== $confirm) {
        header("Location: ../frontend/register.php?error=mismatch");
        exit;
    }

    // 2. Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header("Location: ../frontend/register.php?error=exists");
        exit;
    }

    // 3. Hash Password & Insert
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $role]);
        
        // Success - Redirect to login
        header("Location: ../frontend/login.php?registered=1");
        exit;
    } catch (PDOException $e) {
        header("Location: ../frontend/register.php?error=db");
        exit;
    }
} else {
    header("Location: ../frontend/register.php");
    exit;
}