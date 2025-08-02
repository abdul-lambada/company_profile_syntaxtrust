<?php
class Service {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Service
    public function create($name, $description, $short_description, $icon, $image, $price, $duration, $features, $is_featured, $sort_order) {
        $sql = "INSERT INTO services (name, description, short_description, icon, image, price, duration, features, is_featured, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $short_description, $icon, $image, $price, $duration, $features, $is_featured, $sort_order]);
    }
    
    // Read All Services
    public function getAll() {
        $sql = "SELECT * FROM services WHERE is_active = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Featured Services
    public function getFeatured() {
        $sql = "SELECT * FROM services WHERE is_active = TRUE AND is_featured = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Service by ID
    public function getById($id) {
        $sql = "SELECT * FROM services WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Service
    public function update($id, $name, $description, $short_description, $icon, $image, $price, $duration, $features, $is_featured, $sort_order) {
        $sql = "UPDATE services 
                SET name = ?, description = ?, short_description = ?, icon = ?, image = ?, price = ?, duration = ?, features = ?, is_featured = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $short_description, $icon, $image, $price, $duration, $features, $is_featured, $sort_order, $id]);
    }
    
    // Delete Service (soft delete)
    public function delete($id) {
        $sql = "UPDATE services SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
