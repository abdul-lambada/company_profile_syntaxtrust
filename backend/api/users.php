<?php
require_once '../config/session.php';
require_once '../config/database.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Set JSON response header
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getUsers();
        break;
    case 'POST':
        createUser();
        break;
    case 'PUT':
        updateUser();
        break;
    case 'DELETE':
        deleteUser();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getUsers() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, full_name, phone, user_type, profile_image, bio, created_at FROM users ORDER BY created_at DESC");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'users' => $users]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

function createUser() {
    global $pdo;
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['full_name']) || !isset($input['email']) || !isset($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Full name, email, and password required']);
        return;
    }
    
    $full_name = trim($input['full_name']);
    $email = trim($input['email']);
    $password = password_hash(trim($input['password']), PASSWORD_BCRYPT);
    $username = trim($input['username'] ?? $email);
    $phone = trim($input['phone'] ?? '');
    $user_type = trim($input['user_type'] ?? 'mahasiswa');
    $profile_image = trim($input['profile_image'] ?? '');
    $bio = trim($input['bio'] ?? '');
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, full_name, phone, user_type, profile_image, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $full_name, $phone, $user_type, $profile_image, $bio]);
        
        $userId = $pdo->lastInsertId();
        
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $userId,
                'full_name' => $full_name,
                'email' => $email,
                'username' => $username
            ]
        ]);
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // Duplicate entry
            http_response_code(409);
            echo json_encode(['error' => 'Email already exists']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }
}

function updateUser() {
    global $pdo;
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['id']) || !isset($input['full_name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID, full name, and email required']);
        return;
    }
    
    $id = $input['id'];
    $full_name = trim($input['full_name']);
    $email = trim($input['email']);
    $username = trim($input['username'] ?? $email);
    $phone = trim($input['phone'] ?? '');
    $user_type = trim($input['user_type'] ?? 'mahasiswa');
    $profile_image = trim($input['profile_image'] ?? '');
    $bio = trim($input['bio'] ?? '');
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, username = ?, phone = ?, user_type = ?, profile_image = ?, bio = ? WHERE id = ?");
        $stmt->execute([$full_name, $email, $username, $phone, $user_type, $profile_image, $bio, $id]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

function deleteUser() {
    global $pdo;
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'User ID required']);
        return;
    }
    
    $id = $input['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}
?>
