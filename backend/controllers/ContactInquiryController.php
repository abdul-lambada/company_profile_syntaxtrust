<?php
require_once '../config/database.php';
require_once '../models/ContactInquiry.php';

class ContactInquiryController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all contact inquiries
    public function getAllContactInquiries() {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $inquiries = $contactInquiryModel->getAll();
            $this->sendResponse($inquiries, "Contact inquiries retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving contact inquiries: " . $e->getMessage());
        }
    }
    
    // Get contact inquiry by ID
    public function getContactInquiryById($id) {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $inquiry = $contactInquiryModel->getById($id);
            
            if ($inquiry) {
                $this->sendResponse($inquiry, "Contact inquiry retrieved successfully");
            } else {
                $this->sendError("Contact inquiry not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving contact inquiry: " . $e->getMessage());
        }
    }
    
    // Get contact inquiries by status
    public function getContactInquiriesByStatus($status) {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $inquiries = $contactInquiryModel->getByStatus($status);
            $this->sendResponse($inquiries, "Contact inquiries by status retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving contact inquiries by status: " . $e->getMessage());
        }
    }
    
    // Create new contact inquiry
    public function createContactInquiry() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['name', 'email', 'message'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $result = $contactInquiryModel->create(
                $data['name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['subject'] ?? null,
                $data['message'],
                $data['service_id'] ?? null,
                $data['budget_range'] ?? null,
                $data['timeline'] ?? null,
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Contact inquiry created successfully", 201);
            } else {
                $this->sendError("Failed to create contact inquiry");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating contact inquiry: " . $e->getMessage());
        }
    }
    
    // Update contact inquiry status
    public function updateContactInquiryStatus($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data || !isset($data['status'])) {
                $this->sendError("Status field is required");
                return;
            }
            
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $result = $contactInquiryModel->updateStatus($id, $data['status']);
            
            if ($result) {
                $this->sendResponse(null, "Contact inquiry status updated successfully");
            } else {
                $this->sendError("Failed to update contact inquiry status");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating contact inquiry status: " . $e->getMessage());
        }
    }
    
    // Delete contact inquiry
    public function deleteContactInquiry($id) {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $result = $contactInquiryModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Contact inquiry deleted successfully");
            } else {
                $this->sendError("Failed to delete contact inquiry");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting contact inquiry: " . $e->getMessage());
        }
    }
    
    // Get contact inquiries by service
    public function getContactInquiriesByService($service_id, $service_name) {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $inquiries = $contactInquiryModel->getByService($service_id, $service_name);
            $this->sendResponse($inquiries, "Contact inquiries by service retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving contact inquiries by service: " . $e->getMessage());
        }
    }
    
    // Mark contact inquiry as replied
    public function markAsReplied($id) {
        try {
            $contactInquiryModel = new ContactInquiry($this->pdo);
            $result = $contactInquiryModel->markAsReplied($id);
            
            if ($result) {
                $this->sendResponse(null, "Contact inquiry marked as replied successfully");
            } else {
                $this->sendError("Failed to mark contact inquiry as replied");
            }
        } catch (Exception $e) {
            $this->sendError("Error marking contact inquiry as replied: " . $e->getMessage());
        }
    }
}
?>
