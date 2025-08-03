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
        // Get portfolio items
        try {
            $featured = $_GET['featured'] ?? null;
            $category = $_GET['category'] ?? null;
            
            $sql = "SELECT * FROM portfolio WHERE is_active = 1";
            $params = [];
            
            if ($featured) {
                $sql .= " AND is_featured = 1";
            }
            
            if ($category) {
                $sql .= " AND category = ?";
                $params[] = $category;
            }
            
            $sql .= " ORDER BY created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Decode JSON fields
            foreach ($portfolio as &$item) {
                if (isset($item['technologies']) && $item['technologies']) {
                    $item['technologies'] = json_decode($item['technologies'], true);
                }
                if (isset($item['images']) && $item['images']) {
                    $item['images'] = json_decode($item['images'], true);
                }
            }
            
            echo json_encode(['success' => true, 'portfolio' => $portfolio]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO portfolio (title, description, short_description, client_name, category, technologies, project_url, github_url, image_main, images, start_date, end_date, status, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['title'],
                $input['description'],
                $input['short_description'],
                $input['client_name'],
                $input['category'],
                json_encode($input['technologies']),
                $input['project_url'],
                $input['github_url'],
                $input['image_main'],
                json_encode($input['images']),
                $input['start_date'],
                $input['end_date'],
                $input['status'] ?? 'completed',
                $input['is_featured'] ?? 0
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
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE portfolio SET title = ?, description = ?, short_description = ?, client_name = ?, category = ?, technologies = ?, project_url = ?, github_url = ?, image_main = ?, images = ?, start_date = ?, end_date = ?, status = ?, is_featured = ? WHERE id = ?");
            $stmt->execute([
                $input['title'],
                $input['description'],
                $input['short_description'],
                $input['client_name'],
                $input['category'],
                json_encode($input['technologies']),
                $input['project_url'],
                $input['github_url'],
                $input['image_main'],
                json_encode($input['images']),
                $input['start_date'],
                $input['end_date'],
                $input['status'] ?? 'completed',
                $input['is_featured'] ?? 0,
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
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE portfolio SET is_active = 0 WHERE id = ?");
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
