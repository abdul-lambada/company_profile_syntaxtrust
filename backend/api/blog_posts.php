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
        // Get blog posts
        try {
            $status = $_GET['status'] ?? null;
            $category = $_GET['category'] ?? null;
            $featured = $_GET['featured'] ?? null;
            $slug = $_GET['slug'] ?? null;
            
            $sql = "SELECT bp.*, u.full_name as author_name 
                    FROM blog_posts bp 
                    LEFT JOIN users u ON bp.author_id = u.id";
            $params = [];
            $conditions = [];
            
            if ($status) {
                $conditions[] = "bp.status = ?";
                $params[] = $status;
            }
            
            if ($category) {
                $conditions[] = "bp.category = ?";
                $params[] = $category;
            }
            
            if ($featured) {
                $conditions[] = "bp.is_featured = 1";
            }
            
            if ($slug) {
                $conditions[] = "bp.slug = ?";
                $params[] = $slug;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $sql .= " ORDER BY bp.published_at DESC, bp.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Decode JSON fields
            foreach ($posts as &$post) {
                if (isset($post['tags']) && $post['tags']) {
                    $post['tags'] = json_decode($post['tags'], true);
                }
            }
            
            echo json_encode(['success' => true, 'posts' => $posts]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Generate slug if not provided
        if (empty($input['slug'])) {
            $input['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $input['title'])));
        }
        
        // Set published_at if status is published
        $published_at = null;
        if ($input['status'] === 'published') {
            $published_at = date('Y-m-d H:i:s');
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, excerpt, featured_image, author_id, category, tags, status, published_at, is_featured, meta_title, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['title'],
                $input['slug'],
                $input['content'],
                $input['excerpt'] ?? null,
                $input['featured_image'] ?? null,
                $input['author_id'] ?? $_SESSION['user_id'],
                $input['category'] ?? null,
                isset($input['tags']) ? json_encode($input['tags']) : null,
                $input['status'] ?? 'draft',
                $published_at,
                $input['is_featured'] ?? false,
                $input['meta_title'] ?? null,
                $input['meta_description'] ?? null
            ]);
            
            $post_id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true, 
                'post' => [
                    'id' => $post_id,
                    'slug' => $input['slug']
                ]
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Duplicate entry
                http_response_code(409);
                echo json_encode(['error' => 'Slug already exists']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            }
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
        
        // Set published_at if status is published and not already published
        $published_at = null;
        if ($input['status'] === 'published') {
            $stmt = $pdo->prepare("SELECT published_at FROM blog_posts WHERE id = ?");
            $stmt->execute([$id]);
            $current_post = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$current_post['published_at']) {
                $published_at = date('Y-m-d H:i:s');
            }
        }
        
        try {
            $sql = "UPDATE blog_posts SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, author_id = ?, category = ?, tags = ?, status = ?, is_featured = ?, meta_title = ?, meta_description = ?";
            $params = [
                $input['title'] ?? '',
                $input['slug'] ?? '',
                $input['content'] ?? '',
                $input['excerpt'] ?? null,
                $input['featured_image'] ?? null,
                $input['author_id'] ?? $_SESSION['user_id'],
                $input['category'] ?? null,
                isset($input['tags']) ? json_encode($input['tags']) : null,
                $input['status'] ?? 'draft',
                $input['is_featured'] ?? false,
                $input['meta_title'] ?? null,
                $input['meta_description'] ?? null
            ];
            
            if ($published_at) {
                $sql .= ", published_at = ?";
                $params[] = $published_at;
            }
            
            $sql .= " WHERE id = ?";
            $params[] = $id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Duplicate entry
                http_response_code(409);
                echo json_encode(['error' => 'Slug already exists']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            }
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
            $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
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