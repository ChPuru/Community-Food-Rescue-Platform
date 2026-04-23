<?php
$host = 'localhost';
$dbname = 'foodcycle';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `$dbname`;");
    
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    $message = "Connection failed: " . $e->getMessage();
    if ($e->getCode() == 1045) {
        $message = "Connection failed: Access denied. Please check your MySQL 'root' password.";
    }

    if (defined('API_REQUEST')) {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'error', 'message' => $message]));
    }
    
    die($message);
}
