<?php
class Client {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Client
    public function create($name, $logo, $website_url, $description, $testimonial, $rating, $sort_order) {
        $sql = "INSERT INTO clients (name, logo, website_url, description, testimonial, rating, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $logo, $website_url, $description, $testimonial, $rating, $sort_order]);
    }
    
    // Read All Clients
    public function getAll() {
        $sql = "SELECT * FROM clients WHERE is_active = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Client by ID
    public function getById($id) {
        $sql = "SELECT * FROM clients WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Client
    public function update($id, $name, $logo, $website_url, $description, $testimonial, $rating, $sort_order) {
        $sql = "UPDATE clients 
                SET name = ?, logo = ?, website_url = ?, description = ?, testimonial = ?, rating = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $logo, $website_url, $description, $testimonial, $rating, $sort_order, $id]);
    }
    
    // Delete Client (soft delete)
    public function delete($id) {
        $sql = "UPDATE clients SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
