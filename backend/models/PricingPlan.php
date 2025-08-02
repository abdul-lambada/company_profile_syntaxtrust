<?php
class PricingPlan {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Pricing Plan
    public function create($name, $price, $currency, $billing_period, $description, $features, $is_popular, $sort_order) {
        $sql = "INSERT INTO pricing_plans (name, price, currency, billing_period, description, features, is_popular, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $price, $currency, $billing_period, $description, $features, $is_popular, $sort_order]);
    }
    
    // Read All Pricing Plans
    public function getAll() {
        $sql = "SELECT * FROM pricing_plans WHERE is_active = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Popular Pricing Plan
    public function getPopular() {
        $sql = "SELECT * FROM pricing_plans WHERE is_active = TRUE AND is_popular = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Pricing Plan by ID
    public function getById($id) {
        $sql = "SELECT * FROM pricing_plans WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Pricing Plan
    public function update($id, $name, $price, $currency, $billing_period, $description, $features, $is_popular, $sort_order) {
        $sql = "UPDATE pricing_plans 
                SET name = ?, price = ?, currency = ?, billing_period = ?, description = ?, features = ?, is_popular = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $price, $currency, $billing_period, $description, $features, $is_popular, $sort_order, $id]);
    }
    
    // Delete Pricing Plan (soft delete)
    public function delete($id) {
        $sql = "UPDATE pricing_plans SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
