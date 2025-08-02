<?php
require_once '../config/database.php';
require_once '../models/Portfolio.php';

class PortfolioController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all portfolio items
    public function getAllPortfolioItems() {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $items = $portfolioModel->getAll();
            $this->sendResponse($items, "Portfolio items retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving portfolio items: " . $e->getMessage());
        }
    }
    
    // Get featured portfolio items
    public function getFeaturedPortfolioItems() {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $items = $portfolioModel->getFeatured();
            $this->sendResponse($items, "Featured portfolio items retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving featured portfolio items: " . $e->getMessage());
        }
    }
    
    // Get portfolio items by category
    public function getPortfolioByCategory($category) {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $items = $portfolioModel->getByCategory($category);
            $this->sendResponse($items, "Portfolio items by category retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving portfolio items by category: " . $e->getMessage());
        }
    }
    
    // Get portfolio item by ID
    public function getPortfolioItemById($id) {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $item = $portfolioModel->getById($id);
            
            if ($item) {
                $this->sendResponse($item, "Portfolio item retrieved successfully");
            } else {
                $this->sendError("Portfolio item not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving portfolio item: " . $e->getMessage());
        }
    }
    
    // Create new portfolio item
    public function createPortfolioItem() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['title', 'description', 'client_name', 'category'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $portfolioModel = new Portfolio($this->pdo);
            $result = $portfolioModel->create(
                $data['title'],
                $data['description'],
                $data['short_description'] ?? null,
                $data['client_name'],
                $data['category'],
                json_encode($data['technologies'] ?? []),
                $data['project_url'] ?? null,
                $data['github_url'] ?? null,
                $data['image_main'] ?? null,
                json_encode($data['images'] ?? []),
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['status'] ?? 'completed',
                $data['is_featured'] ?? false
            );
            
            if ($result) {
                $this->sendResponse(null, "Portfolio item created successfully", 201);
            } else {
                $this->sendError("Failed to create portfolio item");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating portfolio item: " . $e->getMessage());
        }
    }
    
    // Update portfolio item
    public function updatePortfolioItem($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $portfolioModel = new Portfolio($this->pdo);
            $result = $portfolioModel->update(
                $id,
                $data['title'] ?? null,
                $data['description'] ?? null,
                $data['short_description'] ?? null,
                $data['client_name'] ?? null,
                $data['category'] ?? null,
                json_encode($data['technologies'] ?? []),
                $data['project_url'] ?? null,
                $data['github_url'] ?? null,
                $data['image_main'] ?? null,
                json_encode($data['images'] ?? []),
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['status'] ?? null,
                $data['is_featured'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Portfolio item updated successfully");
            } else {
                $this->sendError("Failed to update portfolio item");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating portfolio item: " . $e->getMessage());
        }
    }
    
    // Delete portfolio item (soft delete)
    public function deletePortfolioItem($id) {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $result = $portfolioModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Portfolio item deleted successfully");
            } else {
                $this->sendError("Failed to delete portfolio item");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting portfolio item: " . $e->getMessage());
        }
    }
    
    // Search portfolio items by keyword
    public function searchPortfolioItems($keyword) {
        try {
            $portfolioModel = new Portfolio($this->pdo);
            $items = $portfolioModel->search($keyword);
            $this->sendResponse($items, "Portfolio search results retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error searching portfolio items: " . $e->getMessage());
        }
    }
}
?>
