<?php
class Order {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Order
    public function create($order_number, $user_id, $service_id, $pricing_plan_id, $customer_name, $customer_email, $customer_phone, $project_description, $requirements, $total_amount, $payment_method) {
        $sql = "INSERT INTO orders (order_number, user_id, service_id, pricing_plan_id, customer_name, customer_email, customer_phone, project_description, requirements, total_amount, payment_method) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$order_number, $user_id, $service_id, $pricing_plan_id, $customer_name, $customer_email, $customer_phone, $project_description, $requirements, $total_amount, $payment_method]);
    }
    
    // Create order with requirements as JSON
    public function createWithRequirements($order_number, $user_id, $service_id, $pricing_plan_id, $customer_name, $customer_email, $customer_phone, $project_description, $req1, $req2, $req3, $total_amount, $payment_method) {
        $sql = "INSERT INTO orders (order_number, user_id, service_id, pricing_plan_id, customer_name, customer_email, customer_phone, project_description, requirements, total_amount, payment_method) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, JSON_OBJECT('requirement1', ?, 'requirement2', ?, 'requirement3', ?), ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$order_number, $user_id, $service_id, $pricing_plan_id, $customer_name, $customer_email, $customer_phone, $project_description, $req1, $req2, $req3, $total_amount, $payment_method]);
    }
    
    // Read All Orders
    public function getAll() {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Order by ID
    public function getById($id) {
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read Order by Order Number
    public function getByOrderNumber($order_number) {
        $sql = "SELECT * FROM orders WHERE order_number = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$order_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read Orders by Status
    public function getByStatus($status) {
        $sql = "SELECT * FROM orders WHERE status = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Orders by Payment Status
    public function getByPaymentStatus($payment_status) {
        $sql = "SELECT * FROM orders WHERE payment_status = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$payment_status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update Order Status
    public function updateStatus($id, $status) {
        $sql = "UPDATE orders 
                SET status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
    
    // Update Payment Status
    public function updatePaymentStatus($id, $payment_status, $payment_method) {
        $sql = "UPDATE orders 
                SET payment_status = ?, payment_method = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$payment_status, $payment_method, $id]);
    }
    
    // Delete Order
    public function delete($id) {
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get order details with service and plan info
    public function getDetails($id) {
        $sql = "SELECT o.*, s.name as service_name, s.description as service_description, p.name as plan_name, p.description as plan_description
                FROM orders o
                JOIN services s ON o.service_id = s.id
                JOIN pricing_plans p ON o.pricing_plan_id = p.id
                WHERE o.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update order requirements
    public function updateRequirements($id, $req1, $req2, $req3) {
        $sql = "UPDATE orders 
                SET requirements = JSON_SET(requirements, '$.requirement1', ?, '$.requirement2', ?, '$.requirement3', ?), updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$req1, $req2, $req3, $id]);
    }
}
?>
