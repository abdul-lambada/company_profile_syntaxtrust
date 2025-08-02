<?php
require_once '../config/database.php';
require_once '../models/Testimonial.php';

class TestimonialController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all testimonials
    public function getAllTestimonials() {
        try {
            $testimonialModel = new Testimonial($this->pdo);
            $testimonials = $testimonialModel->getAll();
            $this->sendResponse($testimonials, "Testimonials retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving testimonials: " . $e->getMessage());
        }
    }
    
    // Get featured testimonials
    public function getFeaturedTestimonials() {
        try {
            $testimonialModel = new Testimonial($this->pdo);
            $testimonials = $testimonialModel->getFeatured();
            $this->sendResponse($testimonials, "Featured testimonials retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving featured testimonials: " . $e->getMessage());
        }
    }
    
    // Get testimonial by ID
    public function getTestimonialById($id) {
        try {
            $testimonialModel = new Testimonial($this->pdo);
            $testimonial = $testimonialModel->getById($id);
            
            if ($testimonial) {
                $this->sendResponse($testimonial, "Testimonial retrieved successfully");
            } else {
                $this->sendError("Testimonial not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving testimonial: " . $e->getMessage());
        }
    }
    
    // Create new testimonial
    public function createTestimonial() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['client_name', 'testimonial'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $testimonialModel = new Testimonial($this->pdo);
            $result = $testimonialModel->create(
                $data['client_name'],
                $data['client_position'] ?? null,
                $data['company_name'] ?? null,
                $data['testimonial'],
                $data['rating'] ?? null,
                $data['client_image'] ?? null,
                $data['project_name'] ?? null,
                $data['is_featured'] ?? false
            );
            
            if ($result) {
                $this->sendResponse(null, "Testimonial created successfully", 201);
            } else {
                $this->sendError("Failed to create testimonial");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating testimonial: " . $e->getMessage());
        }
    }
    
    // Update testimonial
    public function updateTestimonial($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $testimonialModel = new Testimonial($this->pdo);
            $result = $testimonialModel->update(
                $id,
                $data['client_name'] ?? null,
                $data['client_position'] ?? null,
                $data['company_name'] ?? null,
                $data['testimonial'] ?? null,
                $data['rating'] ?? null,
                $data['client_image'] ?? null,
                $data['project_name'] ?? null,
                $data['is_featured'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Testimonial updated successfully");
            } else {
                $this->sendError("Failed to update testimonial");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating testimonial: " . $e->getMessage());
        }
    }
    
    // Delete testimonial
    public function deleteTestimonial($id) {
        try {
            $testimonialModel = new Testimonial($this->pdo);
            $result = $testimonialModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Testimonial deleted successfully");
            } else {
                $this->sendError("Failed to delete testimonial");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting testimonial: " . $e->getMessage());
        }
    }
}
?>
