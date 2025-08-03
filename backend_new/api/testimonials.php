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
        // Get testimonials
        try {
            $featured = $_GET['featured'] ?? null;
            $service_id = $_GET['service_id'] ?? null;
            
            $sql = "SELECT t.*, s.name as service_name 
                    FROM testimonials t 
                    LEFT JOIN services s ON t.service_id = s.id 
                    WHERE t.is_active = 1";
            $params = [];
            
            if ($featured) {
                $sql .= " AND t.is_featured = 1";
            }
            
            if ($service_id) {
                $sql .= " AND t.service_id = ?";
                $params[] = $service_id;
            }
            
            $sql .= " ORDER BY t.sort_order ASC, t.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'testimonials' => $testimonials]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, client_position, client_company, client_image, content, rating, project_name, service_id, is_featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['client_name'],
                $input['client_position'] ?? null,
                $input['client_company'] ?? null,
                $input['client_image'] ?? null,
                $input['content'],
                $input['rating'] ?? null,
                $input['project_name'] ?? null,
                $input['service_id'] ?? null,
                $input['is_featured'] ?? false,
                $input['sort_order'] ?? 0
            ]);
            
            $testimonial_id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true, 
                'testimonial' => [
                    'id' => $testimonial_id
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
            $stmt = $pdo->prepare("UPDATE testimonials SET client_name = ?, client_position = ?, client_company = ?, client_image = ?, content = ?, rating = ?, project_name = ?, service_id = ?, is_featured = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([
                $input['client_name'] ?? '',
                $input['client_position'] ?? null,
                $input['client_company'] ?? null,
                $input['client_image'] ?? null,
                $input['content'] ?? '',
                $input['rating'] ?? null,
                $input['project_name'] ?? null,
                $input['service_id'] ?? null,
                $input['is_featured'] ?? false,
                $input['sort_order'] ?? 0,
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
            $stmt = $pdo->prepare("UPDATE testimonials SET is_active = 0 WHERE id = ?");
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