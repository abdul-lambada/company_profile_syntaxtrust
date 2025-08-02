<?php
class Notification {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Notification
    public function create($user_id, $title, $message, $type, $related_url) {
        $sql = "INSERT INTO notifications (user_id, title, message, type, related_url) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id, $title, $message, $type, $related_url]);
    }
    
    // Read User Notifications
    public function getByUser($user_id) {
        $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Unread Notifications
    public function getUnreadByUser($user_id) {
        $sql = "SELECT * FROM notifications WHERE user_id = ? AND is_read = FALSE ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Mark Notification as Read
    public function markAsRead($id) {
        $sql = "UPDATE notifications 
                SET is_read = TRUE 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Delete Notification
    public function delete($id) {
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Delete User Notifications
    public function deleteByUser($user_id) {
        $sql = "DELETE FROM notifications WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id]);
    }
}
?>
