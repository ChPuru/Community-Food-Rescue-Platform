<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

$_SESSION = [];
session_destroy();
setcookie("remember_token", "", time() - 3600, "/");

header("Location: login.php");
exit;
?>
