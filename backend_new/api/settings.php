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
        // Get settings
        try {
            $stmt = $pdo->query("SELECT * FROM settings ORDER BY setting_key ASC");
            $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'settings' => $settings]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_type = VALUES(setting_type), description = VALUES(description)");
            $stmt->execute([
                $input['setting_key'],
                $input['setting_value'],
                $input['setting_type'] ?? 'string',
                $input['description']
            ]);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'PUT':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = ?, setting_type = ?, description = ? WHERE setting_key = ?");
            $stmt->execute([
                $input['setting_value'],
                $input['setting_type'] ?? 'string',
                $input['description'],
                $input['setting_key']
            ]);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'DELETE':
        checkAuth();
        
        $key = $_GET['key'] ?? null;
        
        if (!$key) {
            http_response_code(400);
            echo json_encode(['error' => 'Key required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("DELETE FROM settings WHERE setting_key = ?");
            $stmt->execute([$key]);
            
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
