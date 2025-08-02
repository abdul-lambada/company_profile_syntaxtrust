<?php
require_once '../config/database.php';
require_once '../models/Order.php';

class OrderController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all orders
    public function getAllOrders() {
        try {
            $orderModel = new Order($this->pdo);
            $orders = $orderModel->getAll();
            $this->sendResponse($orders, "Orders retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving orders: " . $e->getMessage());
        }
    }
    
    // Get order by ID
    public function getOrderById($id) {
        try {
            $orderModel = new Order($this->pdo);
            $order = $orderModel->getById($id);
            
            if ($order) {
                $this->sendResponse($order, "Order retrieved successfully");
            } else {
                $this->sendError("Order not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving order: " . $e->getMessage());
        }
    }
    
    // Get order by order number
    public function getOrderByOrderNumber($order_number) {
        try {
            $orderModel = new Order($this->pdo);
            $order = $orderModel->getByOrderNumber($order_number);
            
            if ($order) {
                $this->sendResponse($order, "Order retrieved successfully");
            } else {
                $this->sendError("Order not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving order: " . $e->getMessage());
        }
    }
    
    // Get orders by status
    public function getOrdersByStatus($status) {
        try {
            $orderModel = new Order($this->pdo);
            $orders = $orderModel->getByStatus($status);
            $this->sendResponse($orders, "Orders by status retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving orders by status: " . $e->getMessage());
        }
    }
    
    // Get orders by payment status
    public function getOrdersByPaymentStatus($payment_status) {
        try {
            $orderModel = new Order($this->pdo);
            $orders = $orderModel->getByPaymentStatus($payment_status);
            $this->sendResponse($orders, "Orders by payment status retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving orders by payment status: " . $e->getMessage());
        }
    }
    
    // Create new order
    public function createOrder() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['order_number', 'customer_name', 'customer_email', 'project_description', 'total_amount'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $orderModel = new Order($this->pdo);
            $result = $orderModel->create(
                $data['order_number'],
                $data['user_id'] ?? null,
                $data['service_id'] ?? null,
                $data['pricing_plan_id'] ?? null,
                $data['customer_name'],
                $data['customer_email'],
                $data['customer_phone'] ?? null,
                $data['project_description'],
                json_encode($data['requirements'] ?? []),
                $data['total_amount'],
                $data['payment_method'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Order created successfully", 201);
            } else {
                $this->sendError("Failed to create order");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating order: " . $e->getMessage());
        }
    }
    
    // Create order with requirements as JSON
    public function createOrderWithRequirements() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['order_number', 'customer_name', 'customer_email', 'project_description', 'total_amount'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $orderModel = new Order($this->pdo);
            $result = $orderModel->createWithRequirements(
                $data['order_number'],
                $data['user_id'] ?? null,
                $data['service_id'] ?? null,
                $data['pricing_plan_id'] ?? null,
                $data['customer_name'],
                $data['customer_email'],
                $data['customer_phone'] ?? null,
                $data['project_description'],
                $data['requirement1'] ?? null,
                $data['requirement2'] ?? null,
                $data['requirement3'] ?? null,
                $data['total_amount'],
                $data['payment_method'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Order created successfully", 201);
            } else {
                $this->sendError("Failed to create order");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating order: " . $e->getMessage());
        }
    }
    
    // Update order status
    public function updateOrderStatus($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data || !isset($data['status'])) {
                $this->sendError("Status field is required");
                return;
            }
            
            $orderModel = new Order($this->pdo);
            $result = $orderModel->updateStatus($id, $data['status']);
            
            if ($result) {
                $this->sendResponse(null, "Order status updated successfully");
            } else {
                $this->sendError("Failed to update order status");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating order status: " . $e->getMessage());
        }
    }
    
    // Update payment status
    public function updatePaymentStatus($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data || !isset($data['payment_status'])) {
                $this->sendError("Payment status field is required");
                return;
            }
            
            $orderModel = new Order($this->pdo);
            $result = $orderModel->updatePaymentStatus(
                $id, 
                $data['payment_status'], 
                $data['payment_method'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Order payment status updated successfully");
            } else {
                $this->sendError("Failed to update order payment status");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating order payment status: " . $e->getMessage());
        }
    }
    
    // Delete order
    public function deleteOrder($id) {
        try {
            $orderModel = new Order($this->pdo);
            $result = $orderModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Order deleted successfully");
            } else {
                $this->sendError("Failed to delete order");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting order: " . $e->getMessage());
        }
    }
    
    // Get order details with service and plan info
    public function getOrderDetails($id) {
        try {
            $orderModel = new Order($this->pdo);
            $order = $orderModel->getDetails($id);
            
            if ($order) {
                $this->sendResponse($order, "Order details retrieved successfully");
            } else {
                $this->sendError("Order not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving order details: " . $e->getMessage());
        }
    }
    
    // Update order requirements
    public function updateOrderRequirements($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $orderModel = new Order($this->pdo);
            $result = $orderModel->updateRequirements(
                $id,
                $data['requirement1'] ?? null,
                $data['requirement2'] ?? null,
                $data['requirement3'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Order requirements updated successfully");
            } else {
                $this->sendError("Failed to update order requirements");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating order requirements: " . $e->getMessage());
        }
    }
}
?>
