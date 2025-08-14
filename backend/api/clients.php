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
        // Get clients with search and pagination
        try {
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $offset = ($page - 1) * $limit;

            // Base query
            $sql = "FROM clients";
            $where_clause = " WHERE 1=1";
            $params = [];

            // Handle search
            if (!empty($search)) {
                $where_clause .= " AND (name LIKE ? OR description LIKE ? OR website_url LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            // Get total records
            $count_stmt = $pdo->prepare("SELECT COUNT(*) as total " . $sql . $where_clause);
            $count_stmt->execute($params);
            $total_records = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $total_pages = ceil($total_records / $limit);

            // Get records for the current page
            $data_stmt = $pdo->prepare("SELECT * " . $sql . $where_clause . " ORDER BY sort_order ASC, name ASC LIMIT ? OFFSET ?");
            $data_params = array_merge($params, [$limit, $offset]);
            
            // Bind parameters dynamically
            for ($i = 0; $i < count($params); $i++) {
                $data_stmt->bindParam($i + 1, $params[$i]);
            }
            $data_stmt->bindParam(count($params) + 1, $limit, PDO::PARAM_INT);
            $data_stmt->bindParam(count($params) + 2, $offset, PDO::PARAM_INT);
            
            $data_stmt->execute();
            $clients = $data_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true, 
                'clients' => $clients,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total_records' => $total_records,
                    'total_pages' => $total_pages
                ]
            ]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO clients (name, logo, website_url, description, sort_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['name'] ?? '',
                $input['logo'] ?? null,
                $input['website_url'] ?? null,
                $input['description'] ?? null,
                $input['sort_order'] ?? 0
            ]);
            
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
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
            $stmt = $pdo->prepare("UPDATE clients SET name = ?, logo = ?, website_url = ?, description = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([
                $input['name'] ?? '',
                $input['logo'] ?? null,
                $input['website_url'] ?? null,
                $input['description'] ?? null,
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
            $stmt = $pdo->prepare("UPDATE clients SET is_active = 0 WHERE id = ?");
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
