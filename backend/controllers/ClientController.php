<?php
require_once '../config/database.php';
require_once '../models/Client.php';

class ClientController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all clients
    public function getAllClients() {
        try {
            $clientModel = new Client($this->pdo);
            $clients = $clientModel->getAll();
            $this->sendResponse($clients, "Clients retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving clients: " . $e->getMessage());
        }
    }
    
    // Get client by ID
    public function getClientById($id) {
        try {
            $clientModel = new Client($this->pdo);
            $client = $clientModel->getById($id);
            
            if ($client) {
                $this->sendResponse($client, "Client retrieved successfully");
            } else {
                $this->sendError("Client not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving client: " . $e->getMessage());
        }
    }
    
    // Create new client
    public function createClient() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['name'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $clientModel = new Client($this->pdo);
            $result = $clientModel->create(
                $data['name'],
                $data['logo'] ?? null,
                $data['website_url'] ?? null,
                $data['description'] ?? null,
                $data['testimonial'] ?? null,
                $data['rating'] ?? null,
                $data['sort_order'] ?? 0
            );
            
            if ($result) {
                $this->sendResponse(null, "Client created successfully", 201);
            } else {
                $this->sendError("Failed to create client");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating client: " . $e->getMessage());
        }
    }
    
    // Update client
    public function updateClient($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $clientModel = new Client($this->pdo);
            $result = $clientModel->update(
                $id,
                $data['name'] ?? null,
                $data['logo'] ?? null,
                $data['website_url'] ?? null,
                $data['description'] ?? null,
                $data['testimonial'] ?? null,
                $data['rating'] ?? null,
                $data['sort_order'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Client updated successfully");
            } else {
                $this->sendError("Failed to update client");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating client: " . $e->getMessage());
        }
    }
    
    // Delete client (soft delete)
    public function deleteClient($id) {
        try {
            $clientModel = new Client($this->pdo);
            $result = $clientModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Client deleted successfully");
            } else {
                $this->sendError("Failed to delete client");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting client: " . $e->getMessage());
        }
    }
}
?>
