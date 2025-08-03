<?php
require_once '../config/session.php';
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Check authentication for write operations
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit();
    }
}

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get orders
        try {
            $status = $_GET['status'] ?? null;
            $payment_status = $_GET['payment_status'] ?? null;
            $user_id = $_GET['user_id'] ?? null;
            
            $sql = "SELECT o.*, s.name as service_name, p.name as plan_name, u.full_name as customer_full_name 
                    FROM orders o 
                    LEFT JOIN services s ON o.service_id = s.id 
                    LEFT JOIN pricing_plans p ON o.pricing_plan_id = p.id 
                    LEFT JOIN users u ON o.user_id = u.id";
            $params = [];
            $conditions = [];
            
            if ($status) {
                $conditions[] = "o.status = ?";
                $params[] = $status;
            }
            
            if ($payment_status) {
                $conditions[] = "o.payment_status = ?";
                $params[] = $payment_status;
            }
            
            if ($user_id) {
                $conditions[] = "o.user_id = ?";
                $params[] = $user_id;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $sql .= " ORDER BY o.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Decode JSON fields
            foreach ($orders as &$order) {
                if (isset($order['requirements']) && $order['requirements']) {
                    $order['requirements'] = json_decode($order['requirements'], true);
                }
            }
            
            echo json_encode(['success' => true, 'orders' => $orders]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Generate order number
        $order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (order_number, user_id, service_id, pricing_plan_id, customer_name, customer_email, customer_phone, project_description, requirements, total_amount, status, payment_status, payment_method, start_date, estimated_completion, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $order_number,
                $input['user_id'] ?? null,
                $input['service_id'] ?? null,
                $input['pricing_plan_id'] ?? null,
                $input['customer_name'],
                $input['customer_email'],
                $input['customer_phone'] ?? null,
                $input['project_description'] ?? null,
                isset($input['requirements']) ? json_encode($input['requirements']) : null,
                $input['total_amount'],
                $input['status'] ?? 'pending',
                $input['payment_status'] ?? 'unpaid',
                $input['payment_method'] ?? null,
                $input['start_date'] ?? null,
                $input['estimated_completion'] ?? null,
                $input['notes'] ?? null
            ]);
            
            $order_id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true, 
                'order' => [
                    'id' => $order_id,
                    'order_number' => $order_number
                ]
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'PUT':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE orders SET user_id = ?, service_id = ?, pricing_plan_id = ?, customer_name = ?, customer_email = ?, customer_phone = ?, project_description = ?, requirements = ?, total_amount = ?, status = ?, payment_status = ?, payment_method = ?, start_date = ?, estimated_completion = ?, actual_completion = ?, notes = ? WHERE id = ?");
            $stmt->execute([
                $input['user_id'] ?? null,
                $input['service_id'] ?? null,
                $input['pricing_plan_id'] ?? null,
                $input['customer_name'] ?? '',
                $input['customer_email'] ?? '',
                $input['customer_phone'] ?? null,
                $input['project_description'] ?? null,
                isset($input['requirements']) ? json_encode($input['requirements']) : null,
                $input['total_amount'] ?? 0,
                $input['status'] ?? 'pending',
                $input['payment_status'] ?? 'unpaid',
                $input['payment_method'] ?? null,
                $input['start_date'] ?? null,
                $input['estimated_completion'] ?? null,
                $input['actual_completion'] ?? null,
                $input['notes'] ?? null,
                $id
            ]);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'DELETE':
        checkAuth();
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?> 