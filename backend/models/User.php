<?php
class User {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create User
    public function create($username, $email, $password_hash, $full_name, $phone, $user_type, $profile_image, $bio) {
        $sql = "INSERT INTO users (username, email, password_hash, full_name, phone, user_type, profile_image, bio) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $email, $password_hash, $full_name, $phone, $user_type, $profile_image, $bio]);
    }
    
    // Read All Users
    public function getAll() {
        $sql = "SELECT * FROM users WHERE is_active = TRUE ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read User by ID
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read User by Email
    public function getByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update User
    public function update($id, $username, $email, $full_name, $phone, $profile_image, $bio) {
        $sql = "UPDATE users 
                SET username = ?, email = ?, full_name = ?, phone = ?, profile_image = ?, bio = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $email, $full_name, $phone, $profile_image, $bio, $id]);
    }
    
    // Delete User (soft delete)
    public function delete($id) {
        $sql = "UPDATE users SET is_active = FALSE, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // User login verification
    public function verifyLogin($email) {
        $sql = "SELECT id, username, email, password_hash, user_type, is_active, email_verified 
                FROM users 
                WHERE email = ? AND is_active = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update user last login
    public function updateLastLogin($id) {
        $sql = "UPDATE users 
                SET updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Verify user email
    public function verifyEmail($id) {
        $sql = "UPDATE users 
                SET email_verified = TRUE, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Reset user password
    public function resetPassword($id, $password_hash) {
        $sql = "UPDATE users 
                SET password_hash = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$password_hash, $id]);
    }
}
?>
