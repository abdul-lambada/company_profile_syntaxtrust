<?php
class Setting {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Setting
    public function create($setting_key, $setting_value, $setting_type, $description, $is_public) {
        $sql = "INSERT INTO settings (setting_key, setting_value, setting_type, description, is_public) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$setting_key, $setting_value, $setting_type, $description, $is_public]);
    }
    
    // Read All Public Settings
    public function getPublic() {
        $sql = "SELECT * FROM settings WHERE is_public = TRUE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Setting by Key
    public function getByKey($setting_key) {
        $sql = "SELECT * FROM settings WHERE setting_key = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$setting_key]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update Setting
    public function update($setting_key, $setting_value, $setting_type, $description, $is_public) {
        $sql = "UPDATE settings 
                SET setting_value = ?, setting_type = ?, description = ?, is_public = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE setting_key = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$setting_value, $setting_type, $description, $is_public, $setting_key]);
    }
    
    // Delete Setting
    public function delete($setting_key) {
        $sql = "DELETE FROM settings WHERE setting_key = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$setting_key]);
    }
    
    // Update multiple settings
    public function updateMultiple($site_name, $site_description, $contact_email, $contact_phone) {
        $sql = "UPDATE settings 
                SET setting_value = CASE setting_key
                    WHEN 'site_name' THEN ?
                    WHEN 'site_description' THEN ?
                    WHEN 'contact_email' THEN ?
                    WHEN 'contact_phone' THEN ?
                END,
                updated_at = CURRENT_TIMESTAMP
                WHERE setting_key IN ('site_name', 'site_description', 'contact_email', 'contact_phone')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$site_name, $site_description, $contact_email, $contact_phone]);
    }
}
?>
