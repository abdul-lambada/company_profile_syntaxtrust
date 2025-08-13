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
        // Get team members
        try {
            $stmt = $pdo->query("SELECT * FROM team WHERE is_active = 1 ORDER BY sort_order ASC");
            $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Decode JSON fields
            foreach ($team as &$member) {
                if (isset($member['skills']) && $member['skills']) {
                    $member['skills'] = json_decode($member['skills'], true);
                }
            }
            
            echo json_encode(['success' => true, 'team' => $team]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        break;
        
    case 'POST':
        checkAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO team (name, position, bio, email, phone, linkedin_url, github_url, twitter_url, profile_image, skills, experience_years, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['name'],
                $input['position'],
                $input['bio'],
                $input['email'],
                $input['phone'],
                $input['linkedin_url'],
                $input['github_url'],
                $input['twitter_url'],
                $input['profile_image'],
                json_encode($input['skills']),
                $input['experience_years'],
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
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE team SET name = ?, position = ?, bio = ?, email = ?, phone = ?, linkedin_url = ?, github_url = ?, twitter_url = ?, profile_image = ?, skills = ?, experience_years = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([
                $input['name'],
                $input['position'],
                $input['bio'],
                $input['email'],
                $input['phone'],
                $input['linkedin_url'],
                $input['github_url'],
                $input['twitter_url'],
                $input['profile_image'],
                json_encode($input['skills']),
                $input['experience_years'],
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
            echo json_encode(['error' => 'ID required']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE team SET is_active = 0 WHERE id = ?");
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
