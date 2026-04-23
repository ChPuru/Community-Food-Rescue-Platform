<?php
define('API_REQUEST', true);
require_once 'init.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$csrf_token = $_POST['csrf_token'] ?? '';

if ($csrf_token !== $_SESSION['csrf_token']) {
    die("Security token invalid");
}

try {
    if ($action === 'update_profile') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        
        $profile_image = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $filename = "avatar_" . $user_id . "_" . time() . "." . $ext;
            $upload_path = "../frontend/assets/uploads/avatars/" . $filename;
            
            if (!is_dir("../frontend/assets/uploads/avatars/")) {
                mkdir("../frontend/assets/uploads/avatars/", 0777, true);
            }
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {
                $profile_image = "assets/uploads/avatars/" . $filename;
            }
        }

        if ($profile_image) {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, profile_image = ? WHERE id = ?");
            $stmt->execute([$name, $email, $profile_image, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $user_id]);
        }
        
        $_SESSION['user_name'] = $name;
        header("Location: ../frontend/profile.php?status=success");
    } 
    elseif ($action === 'update_logistics') {
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        
        $stmt = $pdo->prepare("UPDATE users SET phone = ?, address = ? WHERE id = ?");
        $stmt->execute([$phone, $address, $user_id]);
        
        header("Location: ../frontend/profile.php?status=success");
    }
    elseif ($action === 'update_password') {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $hash = $stmt->fetchColumn();
        
        if (password_verify($current, $hash)) {
            $new_hash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_hash, $user_id]);
            header("Location: ../frontend/profile.php?status=success");
        } else {
            header("Location: ../frontend/profile.php?status=error&message=Incorrect current password");
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
