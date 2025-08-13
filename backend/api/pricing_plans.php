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
        // Get pricing plans
        try {
            $stmt = $pdo->query("SELECT * FROM pricing_plans WHERE is_active = 1 ORDER BY sort_order ASC");
            $pricing_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Decode JSON fields
            foreach ($pricing_plans as &$plan) {
                if (isset($plan['features']) && $plan['features']) {
                    $plan['features'] = json_decode($plan['features'], true);
                }
                if (isset($plan['technologies']) && $plan['technologies']) {
                    $plan['technologies'] = json_decode($plan['technologies'], true);
                }
            }
            
            echo json_encode(['success' => true, 'pricing_plans' => $pricing_plans]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO pricing_plans (name, subtitle, price, currency, billing_period, description, features, delivery_time, technologies, color, icon, is_popular, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['name'],
                $input['subtitle'] ?? '',
                $input['price'],
                $input['currency'] ?? 'IDR',
                $input['billing_period'] ?? 'one_time',
                $input['description'] ?? '',
                isset($input['features']) ? json_encode($input['features']) : null,
                $input['delivery_time'] ?? '',
                isset($input['technologies']) ? json_encode($input['technologies']) : null,
                $input['color'] ?? '',
                $input['icon'] ?? '',
                $input['is_popular'] ?? false,
                $input['is_active'] ?? true,
                $input['sort_order'] ?? 0
            ]);
            
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'PUT':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID parameter']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE pricing_plans SET name = ?, subtitle = ?, price = ?, currency = ?, billing_period = ?, description = ?, features = ?, delivery_time = ?, technologies = ?, color = ?, icon = ?, is_popular = ?, is_active = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([
                $input['name'],
                $input['subtitle'] ?? '',
                $input['price'],
                $input['currency'] ?? 'IDR',
                $input['billing_period'] ?? 'one_time',
                $input['description'] ?? '',
                isset($input['features']) ? json_encode($input['features']) : null,
                $input['delivery_time'] ?? '',
                isset($input['technologies']) ? json_encode($input['technologies']) : null,
                $input['color'] ?? '',
                $input['icon'] ?? '',
                $input['is_popular'] ?? false,
                $input['is_active'] ?? true,
                $input['sort_order'] ?? 0,
                $id
            ]);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'DELETE':
        checkAuth();
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID parameter']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("DELETE FROM pricing_plans WHERE id = ?");
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
