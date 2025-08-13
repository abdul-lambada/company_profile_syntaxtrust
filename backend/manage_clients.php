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

// Delete client
if (isset($_POST['delete_client']) && isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$client_id]);
        $message = "Client deleted successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error deleting client: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle client status
if (isset($_POST['toggle_status']) && isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
    try {
        $stmt = $pdo->prepare("UPDATE clients SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$client_id]);
        $message = "Client status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating client status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Create new client
if (isset($_POST['create_client'])) {
    $name = $_POST['name'];
    $logo = $_POST['logo'];
    $website_url = $_POST['website_url'];
    $description = $_POST['description'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = intval($_POST['sort_order']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO clients (name, logo, website_url, description, industry, location, is_featured, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $logo, $website_url, $description, $industry, $location, $is_featured, $is_active, $sort_order]);
        $message = "Client created successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error creating client: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Update client
if (isset($_POST['update_client'])) {
    $client_id = $_POST['client_id'];
    $name = $_POST['name'];
    $logo = $_POST['logo'];
    $website_url = $_POST['website_url'];
    $description = $_POST['description'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = intval($_POST['sort_order']);
    
    try {
        $stmt = $pdo->prepare("UPDATE clients SET name = ?, logo = ?, website_url = ?, description = ?, industry = ?, location = ?, is_featured = ?, is_active = ?, sort_order = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$name, $logo, $website_url, $description, $industry, $location, $is_featured, $is_active, $sort_order, $client_id]);
        $message = "Client updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating client: " . $e->getMessage();
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
    $where_clause = "WHERE name LIKE ? OR description LIKE ? OR testimonial LIKE ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param];
}

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM clients $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Get clients with pagination
$sql = "SELECT * FROM clients $where_clause ORDER BY sort_order ASC, created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1 class="h3 mb-0 text-gray-800">Manage Clients</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addClientModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Client
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
                            <h6 class="m-0 font-weight-bold text-primary">Search Clients</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="Search by name, description..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                                <?php if (!empty($search)): ?>
                                    <a href="manage_clients.php" class="btn btn-secondary mb-2 ml-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Clients Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Clients List (<?php echo $total_records; ?> total)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Website</th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clients as $client): ?>
                                            <tr>
                                                <td><?php echo $client['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($client['logo'])): ?>
                                                        <img src="<?php echo htmlspecialchars($client['logo']); ?>" alt="Client Logo" class="img-thumbnail" width="80" height="60" style="object-fit: contain;">
                                                    <?php else: ?>
                                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                                            <i class="fas fa-building"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($client['name']); ?></strong>
                                                    <?php if (!empty($client['description'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($client['description'], 0, 100) . '...'); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($client['website_url'])): ?>
                                                        <a href="<?php echo htmlspecialchars($client['website_url']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-external-link-alt"></i> Visit
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($client['rating']): ?>
                                                        <div class="text-warning">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <i class="fas fa-star<?php echo $i <= $client['rating'] ? '' : '-o'; ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <small class="text-muted"><?php echo $client['rating']; ?>/5</small>
                                                    <?php else: ?>
                                                        <span class="text-muted">No rating</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $client['is_active'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $client['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewClientModal<?php echo $client['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editClientModal<?php echo $client['id']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle this client\'s status?')">
                                                            <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                                                            <button type="submit" name="toggle_status" class="btn btn-sm btn-<?php echo $client['is_active'] ? 'warning' : 'success'; ?>">
                                                                <i class="fas fa-<?php echo $client['is_active'] ? 'ban' : 'check'; ?>"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.')">
                                                            <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                                                            <button type="submit" name="delete_client" class="btn btn-sm btn-danger">
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

    <!-- Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Client</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Industry</label>
                                <input type="text" class="form-control" name="industry">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Logo URL</label>
                            <input type="text" class="form-control" name="logo">
                        </div>
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="url" class="form-control" name="website_url">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1">
                                    <label class="custom-control-label" for="is_featured">Featured Client</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="create_client" class="btn btn-primary">Save Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($clients as $client): ?>
    <!-- View Client Modal -->
    <div class="modal fade" id="viewClientModal<?php echo $client['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><?php echo htmlspecialchars($client['name']); ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <?php if (!empty($client['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($client['logo']); ?>" class="img-fluid mb-3">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <dl class="row">
                                <dt class="col-sm-3">Website</dt>
                                <dd class="col-sm-9">
                                    <?php if (!empty($client['website_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($client['website_url']); ?>" target="_blank">
                                            <?php echo htmlspecialchars($client['website_url']); ?>
                                        </a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </dd>
                                <dt class="col-sm-3">Status</dt>
                                <dd class="col-sm-9">
                                    <span class="badge badge-<?php echo $client['is_active'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $client['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                    <?php if ($client['is_featured']): ?>
                                        <span class="badge badge-warning">Featured</span>
                                    <?php endif; ?>
                                </dd>
                                <?php if (!empty($client['industry'])): ?>
                                <dt class="col-sm-3">Industry</dt>
                                <dd class="col-sm-9"><?php echo htmlspecialchars($client['industry']); ?></dd>
                                <?php endif; ?>
                                <?php if (!empty($client['location'])): ?>
                                <dt class="col-sm-3">Location</dt>
                                <dd class="col-sm-9"><?php echo htmlspecialchars($client['location']); ?></dd>
                                <?php endif; ?>
                                <?php if (!empty($client['description'])): ?>
                                <dt class="col-sm-12 mt-2">Description</dt>
                                <dd class="col-sm-12"><?php echo nl2br(htmlspecialchars($client['description'])); ?></dd>
                                <?php endif; ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="modal fade" id="editClientModal<?php echo $client['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Industry</label>
                                <input type="text" class="form-control" name="industry" value="<?php echo htmlspecialchars($client['industry']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Logo URL</label>
                            <input type="text" class="form-control" name="logo" value="<?php echo htmlspecialchars($client['logo']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="url" class="form-control" name="website_url" value="<?php echo htmlspecialchars($client['website_url']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($client['description']); ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_is_featured_<?php echo $client['id']; ?>" name="is_featured" value="1" <?php echo $client['is_featured'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="edit_is_featured_<?php echo $client['id']; ?>">Featured Client</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_is_active_<?php echo $client['id']; ?>" name="is_active" value="1" <?php echo $client['is_active'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="edit_is_active_<?php echo $client['id']; ?>">Active</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="<?php echo $client['sort_order']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_client" class="btn btn-warning">Update Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Scripts -->
    <?php require_once 'includes/scripts.php'; ?>
    <script>
    // Initialize Summernote for description fields
    $(document).ready(function() {
        $('textarea[name="description"]').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
    </script>
</body>
</html>
