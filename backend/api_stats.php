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
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM listings WHERE status = 'active'");
    $active_listings = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role IN ('donor', 'ngo', 'recipient')");
    $total_users = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM claims");
    $total_claims = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT SUM(l.quantity) FROM listings l JOIN claims c ON l.id = c.listing_id");
    $total_quantity_saved = $stmt->fetchColumn() ?: 0;
    
    $meals_saved = floor($total_quantity_saved / 0.4); 
    $co2_reduced = round($total_quantity_saved * 2.5, 1); 
    
    $stmt = $pdo->query("SELECT COUNT(DISTINCT claimer_id) FROM claims");
    $families_helped = $stmt->fetchColumn() ?: 0;

    $role = $_SESSION['role'];
    $batches_helped = 0;
    
    if ($role === 'donor') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM listings WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $batches_helped = $stmt->fetchColumn();
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM claims WHERE claimer_id = ?");
        $stmt->execute([$user_id]);
        $batches_helped = $stmt->fetchColumn();
    }

    $impact_score = $batches_helped * 10;

    $active_claims = 0;
    if ($role !== 'donor') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM claims WHERE claimer_id = ?");
        $stmt->execute([$user_id]);
        $active_claims = $stmt->fetchColumn();
    }

    $recent_activity = [];
    if ($role === 'donor') {
        $stmt = $pdo->prepare("SELECT created_at as date, title as action, status FROM listings WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$user_id]);
        $recent_activity = $stmt->fetchAll();
    } else {
        $stmt = $pdo->prepare("SELECT c.claimed_at as date, l.title as action, l.status FROM claims c JOIN listings l ON c.listing_id = l.id WHERE c.claimer_id = ? ORDER BY c.claimed_at DESC LIMIT 5");
        $stmt->execute([$user_id]);
        $recent_activity = $stmt->fetchAll();
    }

    echo json_encode([
        'status' => 'success',
        'global' => [
            'active_listings' => $active_listings,
            'total_users' => $total_users,
            'total_claims' => $total_claims,
            'meals_saved' => $meals_saved,
            'co2_reduced' => $co2_reduced,
            'families_helped' => $families_helped
        ],
        'user' => [
            'batches_helped' => $batches_helped,
            'impact_score' => $impact_score,
            'active_claims' => $active_claims,
            'recent_activity' => $recent_activity
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
