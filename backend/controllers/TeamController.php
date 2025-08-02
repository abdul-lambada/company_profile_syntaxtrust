<?php
require_once '../config/database.php';
require_once '../models/Team.php';

class TeamController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all team members
    public function getAllTeamMembers() {
        try {
            $teamModel = new Team($this->pdo);
            $members = $teamModel->getAll();
            $this->sendResponse($members, "Team members retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving team members: " . $e->getMessage());
        }
    }
    
    // Get team member by ID
    public function getTeamMemberById($id) {
        try {
            $teamModel = new Team($this->pdo);
            $member = $teamModel->getById($id);
            
            if ($member) {
                $this->sendResponse($member, "Team member retrieved successfully");
            } else {
                $this->sendError("Team member not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving team member: " . $e->getMessage());
        }
    }
    
    // Create new team member
    public function createTeamMember() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['name', 'position', 'bio'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $teamModel = new Team($this->pdo);
            $result = $teamModel->create(
                $data['name'],
                $data['position'],
                $data['bio'],
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['github_url'] ?? null,
                $data['twitter_url'] ?? null,
                $data['profile_image'] ?? null,
                json_encode($data['skills'] ?? []),
                $data['experience_years'] ?? null,
                $data['sort_order'] ?? 0
            );
            
            if ($result) {
                $this->sendResponse(null, "Team member created successfully", 201);
            } else {
                $this->sendError("Failed to create team member");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating team member: " . $e->getMessage());
        }
    }
    
    // Update team member
    public function updateTeamMember($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $teamModel = new Team($this->pdo);
            $result = $teamModel->update(
                $id,
                $data['name'] ?? null,
                $data['position'] ?? null,
                $data['bio'] ?? null,
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['github_url'] ?? null,
                $data['twitter_url'] ?? null,
                $data['profile_image'] ?? null,
                json_encode($data['skills'] ?? []),
                $data['experience_years'] ?? null,
                $data['sort_order'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Team member updated successfully");
            } else {
                $this->sendError("Failed to update team member");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating team member: " . $e->getMessage());
        }
    }
    
    // Delete team member (soft delete)
    public function deleteTeamMember($id) {
        try {
            $teamModel = new Team($this->pdo);
            $result = $teamModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Team member deleted successfully");
            } else {
                $this->sendError("Failed to delete team member");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting team member: " . $e->getMessage());
        }
    }
    
    // Search team members by skill
    public function searchTeamBySkill($skill) {
        try {
            $teamModel = new Team($this->pdo);
            $members = $teamModel->searchBySkill($skill);
            $this->sendResponse($members, "Team search results retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error searching team members: " . $e->getMessage());
        }
    }
}
?>
