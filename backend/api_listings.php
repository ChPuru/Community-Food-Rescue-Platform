<?php
define('API_REQUEST', true);
header('Content-Type: application/json');
require_once 'init.php';
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT l.*, u.name as operator_name FROM listings l JOIN users u ON l.user_id = u.id WHERE l.status = 'active' ORDER BY l.created_at DESC");
        $stmt->execute();
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => $listings
        ]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
} 
elseif ($method === 'POST') {
    
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Only donors can list food.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $available_until = $_POST['available_until'] ?? '';
    $description = $_POST['description'] ?? '';
    $lat = $_POST['latitude'] ?? null;
    $lng = $_POST['longitude'] ?? null;

    if (empty($title) || empty($available_until)) {
        echo json_encode(['status' => 'error', 'message' => 'Title and Expiry are required.']);
        exit;
    }

    $image_path = null;
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../frontend/assets/uploads/listings/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_name = time() . '_' . basename($_FILES['food_image']['name']);
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['food_image']['tmp_name'], $target_file)) {
            $image_path = 'assets/uploads/listings/' . $file_name;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO listings (user_id, title, category, quantity, available_until, description, image_path, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
        $stmt->execute([$user_id, $title, $category, $quantity, $available_until, $description, $image_path, $lat, $lng]);

        header("Location: ../frontend/dashboard.php?msg=Listing+Published");
        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
