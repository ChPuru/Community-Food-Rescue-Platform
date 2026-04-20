<?php
header('Content-Type: application/json');
require_once 'init.php';
require_once 'db.php';

try {
    $stmt = $pdo->prepare("SELECT l.*, u.name as operator_name FROM listings l JOIN users u ON l.user_id = u.id WHERE l.status = 'active' ORDER BY l.created_at DESC");
    $stmt->execute();
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $listings
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error.'
    ]);
}
