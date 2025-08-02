<?php
require_once '../config/database.php';
require_once '../models/Notification.php';

class NotificationController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all notifications
    public function getAllNotifications() {
        try {
            $notificationModel = new Notification($this->pdo);
            $notifications = $notificationModel->getAll();
            $this->sendResponse($notifications, "Notifications retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving notifications: " . $e->getMessage());
        }
    }
    
    // Get notifications by user ID
    public function getNotificationsByUserId($user_id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $notifications = $notificationModel->getByUserId($user_id);
            $this->sendResponse($notifications, "User notifications retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving user notifications: " . $e->getMessage());
        }
    }
    
    // Get unread notifications by user ID
    public function getUnreadNotificationsByUserId($user_id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $notifications = $notificationModel->getUnreadByUserId($user_id);
            $this->sendResponse($notifications, "Unread notifications retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving unread notifications: " . $e->getMessage());
        }
    }
    
    // Get notification by ID
    public function getNotificationById($id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $notification = $notificationModel->getById($id);
            
            if ($notification) {
                $this->sendResponse($notification, "Notification retrieved successfully");
            } else {
                $this->sendError("Notification not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving notification: " . $e->getMessage());
        }
    }
    
    // Create new notification
    public function createNotification() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['user_id', 'title', 'message'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $notificationModel = new Notification($this->pdo);
            $result = $notificationModel->create(
                $data['user_id'],
                $data['title'],
                $data['message'],
                $data['type'] ?? 'info',
                $data['related_id'] ?? null,
                $data['related_type'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Notification created successfully", 201);
            } else {
                $this->sendError("Failed to create notification");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating notification: " . $e->getMessage());
        }
    }
    
    // Mark notification as read
    public function markAsRead($id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $result = $notificationModel->markAsRead($id);
            
            if ($result) {
                $this->sendResponse(null, "Notification marked as read successfully");
            } else {
                $this->sendError("Failed to mark notification as read");
            }
        } catch (Exception $e) {
            $this->sendError("Error marking notification as read: " . $e->getMessage());
        }
    }
    
    // Mark all notifications as read for a user
    public function markAllAsRead($user_id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $result = $notificationModel->markAllAsRead($user_id);
            
            if ($result) {
                $this->sendResponse(null, "All notifications marked as read successfully");
            } else {
                $this->sendError("Failed to mark all notifications as read");
            }
        } catch (Exception $e) {
            $this->sendError("Error marking all notifications as read: " . $e->getMessage());
        }
    }
    
    // Update notification
    public function updateNotification($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $notificationModel = new Notification($this->pdo);
            $result = $notificationModel->update(
                $id,
                $data['title'] ?? null,
                $data['message'] ?? null,
                $data['type'] ?? null,
                $data['is_read'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Notification updated successfully");
            } else {
                $this->sendError("Failed to update notification");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating notification: " . $e->getMessage());
        }
    }
    
    // Delete notification
    public function deleteNotification($id) {
        try {
            $notificationModel = new Notification($this->pdo);
            $result = $notificationModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Notification deleted successfully");
            } else {
                $this->sendError("Failed to delete notification");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting notification: " . $e->getMessage());
        }
    }
}
?>
