<?php
require_once '../config/database.php';
require_once '../models/Service.php';

class ServiceController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all services
    public function getAllServices() {
        try {
            $serviceModel = new Service($this->pdo);
            $services = $serviceModel->getAll();
            $this->sendResponse($services, "Services retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving services: " . $e->getMessage());
        }
    }
    
    // Get featured services
    public function getFeaturedServices() {
        try {
            $serviceModel = new Service($this->pdo);
            $services = $serviceModel->getFeatured();
            $this->sendResponse($services, "Featured services retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving featured services: " . $e->getMessage());
        }
    }
    
    // Get service by ID
    public function getServiceById($id) {
        try {
            $serviceModel = new Service($this->pdo);
            $service = $serviceModel->getById($id);
            
            if ($service) {
                $this->sendResponse($service, "Service retrieved successfully");
            } else {
                $this->sendError("Service not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving service: " . $e->getMessage());
        }
    }
    
    // Create new service
    public function createService() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['name', 'description', 'short_description'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $serviceModel = new Service($this->pdo);
            $result = $serviceModel->create(
                $data['name'],
                $data['description'],
                $data['short_description'],
                $data['icon'] ?? null,
                $data['image'] ?? null,
                $data['price'] ?? null,
                $data['duration'] ?? null,
                json_encode($data['features'] ?? []),
                $data['is_featured'] ?? false,
                $data['sort_order'] ?? 0
            );
            
            if ($result) {
                $this->sendResponse(null, "Service created successfully", 201);
            } else {
                $this->sendError("Failed to create service");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating service: " . $e->getMessage());
        }
    }
    
    // Update service
    public function updateService($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $serviceModel = new Service($this->pdo);
            $result = $serviceModel->update(
                $id,
                $data['name'] ?? null,
                $data['description'] ?? null,
                $data['short_description'] ?? null,
                $data['icon'] ?? null,
                $data['image'] ?? null,
                $data['price'] ?? null,
                $data['duration'] ?? null,
                json_encode($data['features'] ?? []),
                $data['is_featured'] ?? null,
                $data['sort_order'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Service updated successfully");
            } else {
                $this->sendError("Failed to update service");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating service: " . $e->getMessage());
        }
    }
    
    // Delete service (soft delete)
    public function deleteService($id) {
        try {
            $serviceModel = new Service($this->pdo);
            $result = $serviceModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Service deleted successfully");
            } else {
                $this->sendError("Failed to delete service");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting service: " . $e->getMessage());
        }
    }
    
    // Search services by keyword
    public function searchServices($keyword) {
        try {
            $serviceModel = new Service($this->pdo);
            $services = $serviceModel->search($keyword);
            $this->sendResponse($services, "Search results retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error searching services: " . $e->getMessage());
        }
    }
}
?>
