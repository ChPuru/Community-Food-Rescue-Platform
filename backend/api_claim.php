<?php
define('API_REQUEST', true);
header('Content-Type: application/json');
require_once 'init.php';
require_once 'db.php';
require_once 'mail_service.php';
$mailService = new NotificationService($pdo);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please log in to claim a listing.']);
    exit;
}

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ngo', 'recipient'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Only active NGO operators or individual recipients can claim listings.']);
    exit;
}

$user_id = $_SESSION['user_id'];

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'Security token invalid.']);
    exit;
}

if (!isset($input['listing_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$listing_id = intval($input['listing_id']);

try {
    
    $stmt = $pdo->prepare("SELECT id, user_id, status FROM listings WHERE id = ?");
    $stmt->execute([$listing_id]);
    $listing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$listing) {
        echo json_encode(['status' => 'error', 'message' => 'Listing not found.']);
        exit;
    }

    if ($listing['status'] !== 'active') {
        echo json_encode(['status' => 'error', 'message' => 'This listing has already been claimed or is unavailable.']);
        exit;
    }

    if ($listing['user_id'] == $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot claim your own listing.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM claims WHERE listing_id = ? AND user_id = ?");
    $stmt->execute([$listing_id, $user_id]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'You have already claimed this listing.']);
        exit;
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO claims (listing_id, user_id) VALUES (?, ?)");
    $stmt->execute([$listing_id, $user_id]);

    $stmt = $pdo->prepare("UPDATE listings SET status = 'claimed' WHERE id = ?");
    $stmt->execute([$listing_id]);

    $pdo->commit();

    try {
        $mailService->sendClaimAlert($listing['user_id'], $_SESSION['user_name'], $listing['title']);
    } catch (Exception $e) {
        error_log("Non-critical Notification Error: " . $e->getMessage());
    }

    echo json_encode(['status' => 'success', 'message' => 'Listing claimed successfully!']);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Claim Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while claiming the listing.']);
}
