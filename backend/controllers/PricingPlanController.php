<?php
require_once '../config/database.php';
require_once '../models/PricingPlan.php';

class PricingPlanController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all pricing plans
    public function getAllPricingPlans() {
        try {
            $pricingPlanModel = new PricingPlan($this->pdo);
            $plans = $pricingPlanModel->getAll();
            $this->sendResponse($plans, "Pricing plans retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving pricing plans: " . $e->getMessage());
        }
    }
    
    // Get popular pricing plan
    public function getPopularPricingPlans() {
        try {
            $pricingPlanModel = new PricingPlan($this->pdo);
            $plans = $pricingPlanModel->getPopular();
            $this->sendResponse($plans, "Popular pricing plans retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving popular pricing plans: " . $e->getMessage());
        }
    }
    
    // Get pricing plan by ID
    public function getPricingPlanById($id) {
        try {
            $pricingPlanModel = new PricingPlan($this->pdo);
            $plan = $pricingPlanModel->getById($id);
            
            if ($plan) {
                $this->sendResponse($plan, "Pricing plan retrieved successfully");
            } else {
                $this->sendError("Pricing plan not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving pricing plan: " . $e->getMessage());
        }
    }
    
    // Create new pricing plan
    public function createPricingPlan() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['name', 'price', 'description'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $pricingPlanModel = new PricingPlan($this->pdo);
            $result = $pricingPlanModel->create(
                $data['name'],
                $data['price'],
                $data['currency'] ?? 'IDR',
                $data['billing_period'] ?? 'monthly',
                $data['description'],
                json_encode($data['features'] ?? []),
                $data['is_popular'] ?? false,
                $data['sort_order'] ?? 0
            );
            
            if ($result) {
                $this->sendResponse(null, "Pricing plan created successfully", 201);
            } else {
                $this->sendError("Failed to create pricing plan");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating pricing plan: " . $e->getMessage());
        }
    }
    
    // Update pricing plan
    public function updatePricingPlan($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $pricingPlanModel = new PricingPlan($this->pdo);
            $result = $pricingPlanModel->update(
                $id,
                $data['name'] ?? null,
                $data['price'] ?? null,
                $data['currency'] ?? null,
                $data['billing_period'] ?? null,
                $data['description'] ?? null,
                json_encode($data['features'] ?? []),
                $data['is_popular'] ?? null,
                $data['sort_order'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Pricing plan updated successfully");
            } else {
                $this->sendError("Failed to update pricing plan");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating pricing plan: " . $e->getMessage());
        }
    }
    
    // Delete pricing plan (soft delete)
    public function deletePricingPlan($id) {
        try {
            $pricingPlanModel = new PricingPlan($this->pdo);
            $result = $pricingPlanModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Pricing plan deleted successfully");
            } else {
                $this->sendError("Failed to delete pricing plan");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting pricing plan: " . $e->getMessage());
        }
    }
}
?>
