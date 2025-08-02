<?php
class Team {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Team Member
    public function create($name, $position, $bio, $email, $phone, $linkedin_url, $github_url, $twitter_url, $profile_image, $skills, $experience_years, $sort_order) {
        $sql = "INSERT INTO team (name, position, bio, email, phone, linkedin_url, github_url, twitter_url, profile_image, skills, experience_years, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $position, $bio, $email, $phone, $linkedin_url, $github_url, $twitter_url, $profile_image, $skills, $experience_years, $sort_order]);
    }
    
    // Read All Team Members
    public function getAll() {
        $sql = "SELECT * FROM team WHERE is_active = TRUE ORDER BY sort_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Team Member by ID
    public function getById($id) {
        $sql = "SELECT * FROM team WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Team Member
    public function update($id, $name, $position, $bio, $email, $phone, $linkedin_url, $github_url, $twitter_url, $profile_image, $skills, $experience_years, $sort_order) {
        $sql = "UPDATE team 
                SET name = ?, position = ?, bio = ?, email = ?, phone = ?, linkedin_url = ?, github_url = ?, twitter_url = ?, profile_image = ?, skills = ?, experience_years = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $position, $bio, $email, $phone, $linkedin_url, $github_url, $twitter_url, $profile_image, $skills, $experience_years, $sort_order, $id]);
    }
    
    // Delete Team Member (soft delete)
    public function delete($id) {
        $sql = "UPDATE team SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Search team members by skill
    public function searchBySkill($skill) {
        $sql = "SELECT * FROM team 
                WHERE is_active = TRUE 
                AND JSON_CONTAINS(skills, ?)
                ORDER BY experience_years DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$skill]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
