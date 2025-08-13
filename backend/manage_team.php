<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle CRUD operations
$message = '';
$message_type = '';

// Delete team member
if (isset($_POST['delete_team']) && isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM team WHERE id = ?");
        $stmt->execute([$team_id]);
        $message = "Team member deleted successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error deleting team member: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle team member status
if (isset($_POST['toggle_status']) && isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];
    try {
        $stmt = $pdo->prepare("UPDATE team SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$team_id]);
        $message = "Team member status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating team member status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Create new team member
if (isset($_POST['create_team'])) {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $bio = $_POST['bio'];
    $profile_image = $_POST['profile_image'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // Initialize social links with empty values if not set
    $social_links = [
        'linkedin' => $_POST['linkedin_url'] ?? '',
        'github' => $_POST['github_url'] ?? '',
        'twitter' => $_POST['twitter_url'] ?? ''
    ];
    
    // Filter out empty values and encode to JSON
    $social_links = !empty(array_filter($social_links)) ? json_encode(array_filter($social_links)) : null;
    $skills = $_POST['skills'] ? json_encode(explode(',', $_POST['skills'])) : null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = intval($_POST['sort_order']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO team (name, position, bio, profile_image, email, phone, social_links, skills, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $position, $bio, $profile_image, $email, $phone, $social_links, $skills, $is_active, $sort_order]);
        $message = "Team member created successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error creating team member: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Update team member
if (isset($_POST['update_team'])) {
    $team_id = $_POST['team_id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $bio = $_POST['bio'];
    $profile_image = $_POST['profile_image'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // Initialize social links with empty values if not set
    $social_links = [
        'linkedin' => $_POST['linkedin_url'] ?? '',
        'github' => $_POST['github_url'] ?? '',
        'twitter' => $_POST['twitter_url'] ?? ''
    ];
    
    // Filter out empty values and encode to JSON
    $social_links = !empty(array_filter($social_links)) ? json_encode(array_filter($social_links)) : null;
    $skills = $_POST['skills'] ? json_encode(explode(',', $_POST['skills'])) : null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = intval($_POST['sort_order']);
    
    try {
        $stmt = $pdo->prepare("UPDATE team SET name = ?, position = ?, bio = ?, profile_image = ?, email = ?, phone = ?, social_links = ?, skills = ?, is_active = ?, sort_order = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$name, $position, $bio, $profile_image, $email, $phone, $social_links, $skills, $is_active, $sort_order, $team_id]);
        $message = "Team member updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating team member: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Search and pagination
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Build query
$where_clause = "";
$params = [];

if (!empty($search)) {
    $where_clause = "WHERE name LIKE ? OR position LIKE ? OR bio LIKE ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param];
}

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM team $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Get team members with pagination
$sql = "SELECT * FROM team $where_clause ORDER BY sort_order ASC, created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$team_members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header
require_once 'includes/header.php';
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once 'includes/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once 'includes/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Team</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addTeamModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Team Member
                        </a>
                    </div>

                    <!-- Alert Messages -->
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Search Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Search Team Members</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="Search by name, position..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                                <?php if (!empty($search)): ?>
                                    <a href="manage_team.php" class="btn btn-secondary mb-2 ml-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Team Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Team Members List (<?php echo $total_records; ?> total)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Experience</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($team_members as $member): ?>
                                            <tr>
                                                <td><?php echo $member['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($member['profile_image'])): ?>
                                                        <img src="<?php echo htmlspecialchars($member['profile_image']); ?>" alt="Team Member" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($member['name']); ?></strong>
                                                    <?php if (!empty($member['email'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($member['email']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($member['position']); ?></td>
                                                <td>
                                                    <?php if ($member['experience_years']): ?>
                                                        <?php echo $member['experience_years']; ?> years
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $member['is_active'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $member['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewTeamModal<?php echo $member['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editTeamModal<?php echo $member['id']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle this team member\'s status?')">
                                                            <input type="hidden" name="team_id" value="<?php echo $member['id']; ?>">
                                                            <button type="submit" name="toggle_status" class="btn btn-sm btn-<?php echo $member['is_active'] ? 'warning' : 'success'; ?>">
                                                                <i class="fas fa-<?php echo $member['is_active'] ? 'ban' : 'check'; ?>"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this team member? This action cannot be undone.')">
                                                            <input type="hidden" name="team_id" value="<?php echo $member['id']; ?>">
                                                            <button type="submit" name="delete_team" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($total_pages > 1): ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once 'includes/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Add Team Member Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addTeamModalLabel">Add New Team Member</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="position">Position *</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profile_image">Profile Image URL *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="profile_image" name="profile_image" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="uploadProfileImage">Upload</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="linkedin_url">LinkedIn URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                    </div>
                                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="github_url">GitHub URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-github"></i></span>
                                    </div>
                                    <input type="url" class="form-control" id="github_url" name="github_url">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="twitter_url">Twitter URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                    </div>
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="skills">Skills (comma separated)</label>
                                <input type="text" class="form-control" id="skills" name="skills" placeholder="e.g., PHP, JavaScript, UI/UX">
                                <small class="form-text text-muted">Separate multiple skills with commas</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="experience_years">Years of Experience</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years" min="0">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="create_team" class="btn btn-primary">Save Team Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($team_members as $member): 
        // Initialize optional fields with default values if not set
        $member['email'] = $member['email'] ?? '';
        $member['phone'] = $member['phone'] ?? '';
        $member['bio'] = $member['bio'] ?? '';
        $member['sort_order'] = $member['sort_order'] ?? 0;
        $member['social_links'] = $member['social_links'] ?? '{}';
        $member['skills'] = $member['skills'] ?? '[]';
        
        // Decode JSON fields
        $social_links = json_decode($member['social_links'], true) ?? [];
        $skills = json_decode($member['skills'], true) ?? [];
        
        // Ensure arrays
        $social_links = is_array($social_links) ? $social_links : [];
        $skills = is_array($skills) ? $skills : [];
    ?>
    <!-- View Team Member Modal -->
    <div class="modal fade" id="viewTeamModal<?php echo $member['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><?php echo htmlspecialchars($member['name']); ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <?php if (!empty($member['profile_image'])): ?>
                                <img src="<?php echo htmlspecialchars($member['profile_image']); ?>" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x"></i>
                                </div>
                            <?php endif; ?>
                            <h4><?php echo htmlspecialchars($member['name']); ?></h4>
                            <h5 class="text-muted"><?php echo htmlspecialchars($member['position']); ?></h5>
                            
                            <?php if (!empty($member['email']) || !empty($member['phone'])): ?>
                            <div class="mt-3">
                                <?php if (!empty($member['email'])): ?>
                                    <div class="mb-2">
                                        <i class="fas fa-envelope mr-2"></i>
                                        <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>">
                                            <?php echo htmlspecialchars($member['email']); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($member['phone'])): ?>
                                    <div>
                                        <i class="fas fa-phone mr-2"></i>
                                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $member['phone']); ?>">
                                            <?php echo htmlspecialchars($member['phone']); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php 
                            $social_links = [
                                'linkedin' => ['icon' => 'linkedin', 'class' => 'btn-outline-primary', 'url' => $member['linkedin_url'] ?? ''],
                                'github' => ['icon' => 'github', 'class' => 'btn-outline-dark', 'url' => $member['github_url'] ?? ''],
                                'twitter' => ['icon' => 'twitter', 'class' => 'btn-outline-info', 'url' => $member['twitter_url'] ?? '']
                            ];
                            $has_social_links = !empty(array_filter(array_column($social_links, 'url'), 'strlen'));
                            ?>
                            
                            <?php if ($has_social_links): ?>
                            <div class="mt-3">
                                <?php foreach ($social_links as $key => $social): ?>
                                    <?php if (!empty($social['url'])): ?>
                                        <a href="<?php echo htmlspecialchars($social['url']); ?>" 
                                           target="_blank" 
                                           class="btn btn-sm <?php echo $social['class']; ?> btn-circle mr-1 mb-1"
                                           data-toggle="tooltip" 
                                           title="<?php echo ucfirst($key); ?>">
                                            <i class="fab fa-<?php echo $social['icon']; ?>"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($member['experience_years'])): ?>
                                <div class="mt-3">
                                    <span class="badge badge-primary">
                                        <i class="fas fa-briefcase mr-1"></i>
                                        <?php echo htmlspecialchars($member['experience_years']); ?> years experience
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <?php if (!empty($member['bio'])): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Bio</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php echo nl2br(htmlspecialchars($member['bio'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($skills)): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Skills</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap">
                                            <?php foreach ($skills as $skill): ?>
                                                <span class="badge badge-secondary mr-2 mb-2">
                                                    <?php echo htmlspecialchars(trim($skill)); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6
                                <?php if (!empty($member['sort_order'])): ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Sort Order</h6>
                                                    <small class="text-muted">Display priority</small>
                                                </div>
                                                <span class="badge badge-primary">
                                                    <?php echo htmlspecialchars($member['sort_order']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Status</h6>
                                                    <small class="text-muted">Team member visibility</small>
                                                </div>
                                                <span class="badge badge-<?php echo $member['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $member['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Team Member Modal -->
    <div class="modal fade" id="editTeamModal<?php echo $member['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Team Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="team_id" value="<?php echo $member['id']; ?>">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Position *</label>
                                <input type="text" class="form-control" name="position" value="<?php echo htmlspecialchars($member['position']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea class="form-control" name="bio" rows="3"><?php echo htmlspecialchars($member['bio']); ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($member['email']); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($member['phone']); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Profile Image URL *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="profile_image" value="<?php echo htmlspecialchars($member['profile_image']); ?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('profile_image_upload').click()">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                    <input type="file" id="profile_image_upload" style="display: none;" accept="image/*">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>LinkedIn URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                    </div>
                                    <input type="url" class="form-control" name="linkedin_url" value="<?php echo htmlspecialchars($member['linkedin_url'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>GitHub URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-github"></i></span>
                                    </div>
                                    <input type="url" class="form-control" name="github_url" value="<?php echo htmlspecialchars($member['github_url'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Twitter URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                    </div>
                                    <input type="url" class="form-control" name="twitter_url" value="<?php echo htmlspecialchars($member['twitter_url'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Skills (comma separated)</label>
                                <input type="text" class="form-control" name="skills" 
                                       value="<?php echo htmlspecialchars(is_array($skills) ? implode(', ', $skills) : ''); ?>" 
                                       placeholder="e.g., PHP, JavaScript, UI/UX">
                                <small class="form-text text-muted">Separate multiple skills with commas</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Years of Experience</label>
                                <input type="number" class="form-control" name="experience_years" 
                                       value="<?php echo htmlspecialchars($member['experience_years'] ?? ''); ?>" min="0">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" 
                                       value="<?php echo htmlspecialchars($member['sort_order'] ?? '0'); ?>" min="0">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active_<?php echo $member['id']; ?>" 
                                       name="is_active" value="1" <?php echo ($member['is_active'] ?? true) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="is_active_<?php echo $member['id']; ?>">Active</label>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_team" class="btn btn-warning">Update Team Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Scripts -->
    <?php require_once 'includes/scripts.php'; ?>
    
    <script>
    // Initialize tooltips and rich text editor
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize Summernote for bio field
        $('textarea[name="bio"]').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
    </script>
</body>

</html>
