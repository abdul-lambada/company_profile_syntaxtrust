<?php
require_once '../config/database.php';
require_once '../models/Setting.php';

class SettingController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all settings
    public function getAllSettings() {
        try {
            $settingModel = new Setting($this->pdo);
            $settings = $settingModel->getAll();
            $this->sendResponse($settings, "Settings retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving settings: " . $e->getMessage());
        }
    }
    
    // Get setting by key
    public function getSettingByKey($key) {
        try {
            $settingModel = new Setting($this->pdo);
            $setting = $settingModel->getByKey($key);
            
            if ($setting) {
                $this->sendResponse($setting, "Setting retrieved successfully");
            } else {
                $this->sendError("Setting not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving setting: " . $e->getMessage());
        }
    }
    
    // Get multiple settings by keys
    public function getSettingsByKeys() {
        try {
            // Get POST data (array of keys)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data || !isset($data['keys']) || !is_array($data['keys'])) {
                $this->sendError("Invalid keys data provided");
                return;
            }
            
            $settingModel = new Setting($this->pdo);
            $settings = $settingModel->getByKeys($data['keys']);
            $this->sendResponse($settings, "Settings retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving settings: " . $e->getMessage());
        }
    }
    
    // Create new setting
    public function createSetting() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['setting_key', 'setting_value'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $settingModel = new Setting($this->pdo);
            $result = $settingModel->create(
                $data['setting_key'],
                $data['setting_value'],
                $data['description'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Setting created successfully", 201);
            } else {
                $this->sendError("Failed to create setting");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating setting: " . $e->getMessage());
        }
    }
    
    // Update setting
    public function updateSetting($key) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $settingModel = new Setting($this->pdo);
            $result = $settingModel->update(
                $key,
                $data['setting_value'] ?? null,
                $data['description'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Setting updated successfully");
            } else {
                $this->sendError("Failed to update setting");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating setting: " . $e->getMessage());
        }
    }
    
    // Update multiple settings
    public function updateMultipleSettings() {
        try {
            // Get PUT data (array of settings)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data || !isset($data['settings']) || !is_array($data['settings'])) {
                $this->sendError("Invalid settings data provided");
                return;
            }
            
            $settingModel = new Setting($this->pdo);
            $result = $settingModel->updateMultiple($data['settings']);
            
            if ($result) {
                $this->sendResponse(null, "Settings updated successfully");
            } else {
                $this->sendError("Failed to update settings");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating settings: " . $e->getMessage());
        }
    }
    
    // Delete setting
    public function deleteSetting($key) {
        try {
            $settingModel = new Setting($this->pdo);
            $result = $settingModel->delete($key);
            
            if ($result) {
                $this->sendResponse(null, "Setting deleted successfully");
            } else {
                $this->sendError("Failed to delete setting");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting setting: " . $e->getMessage());
        }
    }
}
?>
