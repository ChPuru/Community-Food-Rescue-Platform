<?php
define('API_REQUEST', true);
header('Content-Type: application/json');
require_once 'init.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY sent_at DESC LIMIT 10");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $notifications
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error'
    ]);
}
