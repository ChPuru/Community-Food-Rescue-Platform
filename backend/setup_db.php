<?php
require_once __DIR__ . '/db.php';
try {
    // Attempt to add rating column if it does not exist
    try {
        $pdo->exec("ALTER TABLE feedback ADD COLUMN rating INT NOT NULL DEFAULT 5;");
    } catch (PDOException $e) {}

    // Add role into users schema
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('donor', 'ngo') NOT NULL DEFAULT 'donor';");
    } catch (PDOException $e) {}

    // Add profile details
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL;");
        $pdo->exec("ALTER TABLE users ADD COLUMN address TEXT DEFAULT NULL;");
        $pdo->exec("ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL;");
    } catch (PDOException $e) {}

    // Add image_path to listings
    try {
        $pdo->exec("ALTER TABLE listings ADD COLUMN image_path VARCHAR(255) DEFAULT NULL;");
    } catch (PDOException $e) {}

    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        type VARCHAR(50) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        body TEXT NOT NULL,
        sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );");
    
    echo "SCHEMA SUCCESS";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>