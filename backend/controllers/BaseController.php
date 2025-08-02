<?php
class BaseController {
    protected $pdo;
    
    public function __construct() {
        $this->pdo = connectDB();
    }
    
    // Return JSON response
    protected function sendResponse($data, $message = "", $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
        exit();
    }
    
    // Return error response
    protected function sendError($message, $code = 400) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $code,
            'message' => $message,
            'data' => null
        ]);
        exit();
    }
}
?>
