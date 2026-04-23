<?php
$host = 'localhost';
$dbname = 'foodcycle';
$username = 'root';

$possible_passwords = ['', 'root', 'password'];
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
    $message = "Database Connection failed. Your team might have a custom MySQL password. Please open 'backend/db.php' and update the \$possible_passwords array with your actual password. Error: " . $last_error;
    
    if (defined('API_REQUEST')) {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'error', 'message' => $message]));
    }
    die($message);
}
