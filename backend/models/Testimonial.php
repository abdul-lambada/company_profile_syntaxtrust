<?php
class Testimonial {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Testimonial
    public function create($client_name, $client_position, $client_company, $client_image, $content, $rating, $project_name, $service_id, $is_featured, $sort_order) {
        $sql = "INSERT INTO testimonials (client_name, client_position, client_company, client_image, content, rating, project_name, service_id, is_featured, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$client_name, $client_position, $client_company, $client_image, $content, $rating, $project_name, $service_id, $is_featured, $sort_order]);
    }
    
    // Read All Active Testimonials
    public function getAll() {
        $sql = "SELECT * FROM testimonials WHERE is_active = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Featured Testimonials
    public function getFeatured() {
        $sql = "SELECT * FROM testimonials WHERE is_active = TRUE AND is_featured = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Testimonial by ID
    public function getById($id) {
        $sql = "SELECT * FROM testimonials WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Testimonial
    public function update($id, $client_name, $client_position, $client_company, $client_image, $content, $rating, $project_name, $service_id, $is_featured, $sort_order) {
        $sql = "UPDATE testimonials 
                SET client_name = ?, client_position = ?, client_company = ?, client_image = ?, content = ?, rating = ?, project_name = ?, service_id = ?, is_featured = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$client_name, $client_position, $client_company, $client_image, $content, $rating, $project_name, $service_id, $is_featured, $sort_order, $id]);
    }
    
    // Delete Testimonial (soft delete)
    public function delete($id) {
        $sql = "UPDATE testimonials SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
