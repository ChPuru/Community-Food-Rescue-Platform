<?php
class NotificationService {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function send($user_id, $type, $subject, $body) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO notifications (user_id, type, subject, body) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$user_id, $type, $subject, $body]);
        } catch (PDOException $e) {
            error_log("Mail Service Error: " . $e->getMessage());
            return false;
        }
    }

    public function sendWelcome($user_id, $user_name) {
        $subject = "Welcome to Rescue_Arch, $user_name!";
        $body = "Hi $user_name,\n\nWelcome to the logistics network. Your operator account is now active. You can start sharing or rescuing food immediately.\n\nBest,\nThe Rescue_Arch Team";
        return $this->send($user_id, 'welcome', $subject, $body);
    }

    public function sendClaimAlert($donor_id, $ngo_name, $listing_title) {
        $subject = "Food Claimed: $listing_title";
        $body = "Great news!\n\nYour listing '$listing_title' has been claimed by $ngo_name. Please check the coordinates in your dashboard to coordinate the pickup.\n\nThank you for reducing waste!";
        return $this->send($donor_id, 'claim_alert', $subject, $body);
    }
}
