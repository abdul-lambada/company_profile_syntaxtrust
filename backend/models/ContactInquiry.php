<?php
class ContactInquiry {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Contact Inquiry
    public function create($name, $email, $phone, $subject, $message, $service_id, $budget_range, $timeline, $ip_address, $user_agent) {
        $sql = "INSERT INTO contact_inquiries (name, email, phone, subject, message, service_id, budget_range, timeline, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $email, $phone, $subject, $message, $service_id, $budget_range, $timeline, $ip_address, $user_agent]);
    }
    
    // Read All Contact Inquiries
    public function getAll() {
        $sql = "SELECT * FROM contact_inquiries ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Contact Inquiry by ID
    public function getById($id) {
        $sql = "SELECT * FROM contact_inquiries WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read Contact Inquiries by Status
    public function getByStatus($status) {
        $sql = "SELECT * FROM contact_inquiries WHERE status = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update Contact Inquiry Status
    public function updateStatus($id, $status) {
        $sql = "UPDATE contact_inquiries 
                SET status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
    
    // Delete Contact Inquiry
    public function delete($id) {
        $sql = "DELETE FROM contact_inquiries WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get contact inquiries by service
    public function getByService($service_id, $service_name) {
        $sql = "SELECT c.*, s.name as service_name
                FROM contact_inquiries c
                LEFT JOIN services s ON c.service_id = s.id
                WHERE c.service_id = ? OR s.name LIKE ?
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$service_id, "%$service_name%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update contact inquiry with reply tracking
    public function markAsReplied($id) {
        $sql = "UPDATE contact_inquiries 
                SET status = 'replied', updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
