<?php
require_once '../config/database.php';
require_once '../models/User.php';

class UserController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all users
    public function getAllUsers() {
        try {
            $userModel = new User($this->pdo);
            $users = $userModel->getAll();
            $this->sendResponse($users, "Users retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving users: " . $e->getMessage());
        }
    }
    
    // Get user by ID
    public function getUserById($id) {
        try {
            $userModel = new User($this->pdo);
            $user = $userModel->getById($id);
            
            if ($user) {
                $this->sendResponse($user, "User retrieved successfully");
            } else {
                $this->sendError("User not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving user: " . $e->getMessage());
        }
    }
    
    // Create new user
    public function createUser() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['username', 'email', 'password_hash', 'full_name', 'user_type'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $userModel = new User($this->pdo);
            $result = $userModel->create(
                $data['username'],
                $data['email'],
                $data['password_hash'],
                $data['full_name'],
                $data['phone'] ?? null,
                $data['user_type'],
                $data['profile_image'] ?? null,
                $data['bio'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "User created successfully", 201);
            } else {
                $this->sendError("Failed to create user");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating user: " . $e->getMessage());
        }
    }
    
    // Update user
    public function updateUser($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $userModel = new User($this->pdo);
            $result = $userModel->update(
                $id,
                $data['username'] ?? null,
                $data['email'] ?? null,
                $data['full_name'] ?? null,
                $data['phone'] ?? null,
                $data['profile_image'] ?? null,
                $data['bio'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "User updated successfully");
            } else {
                $this->sendError("Failed to update user");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating user: " . $e->getMessage());
        }
    }
    
    // Delete user (soft delete)
    public function deleteUser($id) {
        try {
            $userModel = new User($this->pdo);
            $result = $userModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "User deleted successfully");
            } else {
                $this->sendError("Failed to delete user");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting user: " . $e->getMessage());
        }
    }
    
    // User login
    public function login() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['email']) || !isset($data['password'])) {
                $this->sendError("Email and password are required");
                return;
            }
            
            $userModel = new User($this->pdo);
            $user = $userModel->verifyLogin($data['email']);
            
            if ($user && password_verify($data['password'], $user['password_hash'])) {
                // Update last login
                $userModel->updateLastLogin($user['id']);
                
                // Start session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Remove password_hash from response
                unset($user['password_hash']);
                
                $this->sendResponse($user, "Login successful");
            } else {
                $this->sendError("Invalid credentials", 401);
            }
        } catch (Exception $e) {
            $this->sendError("Error during login: " . $e->getMessage());
        }
    }
    
    // User logout
    public function logout() {
        try {
            session_start();
            session_destroy();
            $this->sendResponse(null, "Logout successful");
        } catch (Exception $e) {
            $this->sendError("Error during logout: " . $e->getMessage());
        }
    }
}
?>
