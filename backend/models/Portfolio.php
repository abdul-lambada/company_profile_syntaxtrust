<?php
class Portfolio {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Portfolio Item
    public function create($title, $description, $short_description, $client_name, $category, $technologies, $project_url, $github_url, $image_main, $images, $start_date, $end_date, $status, $is_featured) {
        $sql = "INSERT INTO portfolio (title, description, short_description, client_name, category, technologies, project_url, github_url, image_main, images, start_date, end_date, status, is_featured) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $description, $short_description, $client_name, $category, $technologies, $project_url, $github_url, $image_main, $images, $start_date, $end_date, $status, $is_featured]);
    }
    
    // Read All Portfolio Items
    public function getAll() {
        $sql = "SELECT * FROM portfolio WHERE is_active = TRUE ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Featured Portfolio Items
    public function getFeatured() {
        $sql = "SELECT * FROM portfolio WHERE is_active = TRUE AND is_featured = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Portfolio by Category
    public function getByCategory($category) {
        $sql = "SELECT * FROM portfolio WHERE is_active = TRUE AND category = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Portfolio by ID
    public function getById($id) {
        $sql = "SELECT * FROM portfolio WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Portfolio Item
    public function update($id, $title, $description, $short_description, $client_name, $category, $technologies, $project_url, $github_url, $image_main, $images, $start_date, $end_date, $status, $is_featured) {
        $sql = "UPDATE portfolio 
                SET title = ?, description = ?, short_description = ?, client_name = ?, category = ?, technologies = ?, project_url = ?, github_url = ?, image_main = ?, images = ?, start_date = ?, end_date = ?, status = ?, is_featured = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $description, $short_description, $client_name, $category, $technologies, $project_url, $github_url, $image_main, $images, $start_date, $end_date, $status, $is_featured, $id]);
    }
    
    // Delete Portfolio Item (soft delete)
    public function delete($id) {
        $sql = "UPDATE portfolio SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Search portfolio by keyword
    public function search($keyword) {
        $sql = "SELECT * FROM portfolio 
                WHERE is_active = TRUE 
                AND (title LIKE ? OR description LIKE ? OR client_name LIKE ? OR category LIKE ?)
                ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
