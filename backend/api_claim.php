<?php
header('Content-Type: application/json');
require_once 'init.php';
require_once 'db.php';
require_once 'mail_service.php';
$mailService = new NotificationService($pdo);

// Check authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please log in to claim a listing.']);
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ngo') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Only active NGO operators can claim listings.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get POST data
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
    // 1. Verify listing is active and exists
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

    // Optional: Prevent user from claiming their own listing
    if ($listing['user_id'] == $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot claim your own listing.']);
        exit;
    }

    // 2. Prevent duplicate claims via a check (though UNIQUE constraint handles this too)
    $stmt = $pdo->prepare("SELECT id FROM claims WHERE listing_id = ? AND claimer_id = ?");
    $stmt->execute([$listing_id, $user_id]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'You have already claimed this listing.']);
        exit;
    }

    // 3. Perform atomic claim operation mapping
    $pdo->beginTransaction();

    // Insert claim
    $stmt = $pdo->prepare("INSERT INTO claims (listing_id, claimer_id) VALUES (?, ?)");
    $stmt->execute([$listing_id, $user_id]);

    // Update listing status
    $stmt = $pdo->prepare("UPDATE listings SET status = 'claimed' WHERE id = ?");
    $stmt->execute([$listing_id]);

    $pdo->commit();

    // Trigger Notification
    $mailService->sendClaimAlert($listing['user_id'], $_SESSION['user_name'], $listing['title']);

    echo json_encode(['status' => 'success', 'message' => 'Listing claimed successfully!']);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Claim Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while claiming the listing.']);
}