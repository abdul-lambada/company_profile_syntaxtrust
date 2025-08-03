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
        // Get notifications for current user
        try {
            $user_id = $_SESSION['user_id'] ?? null;
            $is_read = $_GET['is_read'] ?? null;
            $type = $_GET['type'] ?? null;
            
            if (!$user_id) {
                http_response_code(401);
                echo json_encode(['error' => 'User not authenticated']);
                exit();
            }
            
            $sql = "SELECT * FROM notifications WHERE user_id = ?";
            $params = [$user_id];
            
            if ($is_read !== null) {
                $sql .= " AND is_read = ?";
                $params[] = $is_read ? 1 : 0;
            }
            
            if ($type) {
                $sql .= " AND type = ?";
                $params[] = $type;
            }
            
            $sql .= " ORDER BY created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'notifications' => $notifications]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO notifications (user_id, title, message, type, related_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['user_id'],
                $input['title'],
                $input['message'],
                $input['type'] ?? 'info',
                $input['related_url'] ?? null
            ]);
            
            $notification_id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true, 
                'notification' => [
                    'id' => $notification_id
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
        
        // Verify user owns this notification
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT id FROM notifications WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        
        if (!$stmt->fetch()) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE notifications SET is_read = ? WHERE id = ?");
            $stmt->execute([
                $input['is_read'] ?? false,
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
        
        // Verify user owns this notification
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT id FROM notifications WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        
        if (!$stmt->fetch()) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ?");
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