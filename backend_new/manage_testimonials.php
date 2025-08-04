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

// Delete testimonial
if (isset($_POST['delete_testimonial']) && isset($_POST['testimonial_id'])) {
    $testimonial_id = $_POST['testimonial_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$testimonial_id]);
        $message = "Testimonial deleted successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error deleting testimonial: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle testimonial status
if (isset($_POST['toggle_status']) && isset($_POST['testimonial_id'])) {
    $testimonial_id = $_POST['testimonial_id'];
    try {
        $stmt = $pdo->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$testimonial_id]);
        $message = "Testimonial status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating testimonial status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle featured status
if (isset($_POST['toggle_featured']) && isset($_POST['testimonial_id'])) {
    $testimonial_id = $_POST['testimonial_id'];
    try {
        $stmt = $pdo->prepare("UPDATE testimonials SET is_featured = NOT is_featured WHERE id = ?");
        $stmt->execute([$testimonial_id]);
        $message = "Featured status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating featured status: " . $e->getMessage();
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
    $where_clause = "WHERE client_name LIKE ? OR client_position LIKE ? OR client_company LIKE ? OR content LIKE ? OR project_name LIKE ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param, $search_param, $search_param];
}

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM testimonials $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Get testimonials with pagination
$sql = "SELECT t.*, s.name as service_name FROM testimonials t LEFT JOIN services s ON t.service_id = s.id $where_clause ORDER BY t.is_featured DESC, t.sort_order ASC, t.created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1 class="h3 mb-0 text-gray-800">Manage Testimonials</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addTestimonialModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Testimonial
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
                            <h6 class="m-0 font-weight-bold text-primary">Search Testimonials</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="Search by client name, company, project..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                                <?php if (!empty($search)): ?>
                                    <a href="manage_testimonials.php" class="btn btn-secondary mb-2 ml-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Testimonials Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Testimonials List (<?php echo $total_records; ?> total)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Client Photo</th>
                                            <th>Client Info</th>
                                            <th>Content</th>
                                            <th>Rating</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Featured</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($testimonials as $testimonial): ?>
                                            <tr>
                                                <td><?php echo $testimonial['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($testimonial['client_image'])): ?>
                                                        <img src="<?php echo htmlspecialchars($testimonial['client_image']); ?>" alt="Client" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($testimonial['client_name']); ?></strong>
                                                    <?php if (!empty($testimonial['client_position'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($testimonial['client_position']); ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($testimonial['client_company'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($testimonial['client_company']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(substr($testimonial['content'], 0, 150) . '...'); ?>
                                                    <?php if (!empty($testimonial['project_name'])): ?>
                                                        <br><small class="text-info">Project: <?php echo htmlspecialchars($testimonial['project_name']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($testimonial['rating']): ?>
                                                        <div class="text-warning">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <i class="fas fa-star<?php echo $i <= $testimonial['rating'] ? '' : '-o'; ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <small class="text-muted"><?php echo $testimonial['rating']; ?>/5</small>
                                                    <?php else: ?>
                                                        <span class="text-muted">No rating</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($testimonial['service_name'])): ?>
                                                        <span class="badge badge-info"><?php echo htmlspecialchars($testimonial['service_name']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $testimonial['is_active'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $testimonial['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $testimonial['is_featured'] ? 'warning' : 'light'; ?>">
                                                        <?php echo $testimonial['is_featured'] ? 'Featured' : 'Regular'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewTestimonialModal<?php echo $testimonial['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editTestimonialModal<?php echo $testimonial['id']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle this testimonial\'s status?')">
                                                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                                                            <button type="submit" name="toggle_status" class="btn btn-sm btn-<?php echo $testimonial['is_active'] ? 'warning' : 'success'; ?>">
                                                                <i class="fas fa-<?php echo $testimonial['is_active'] ? 'ban' : 'check'; ?>"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle featured status?')">
                                                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                                                            <button type="submit" name="toggle_featured" class="btn btn-sm btn-<?php echo $testimonial['is_featured'] ? 'secondary' : 'warning'; ?>">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.')">
                                                            <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                                                            <button type="submit" name="delete_testimonial" class="btn btn-sm btn-danger">
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

    <!-- Scripts -->
    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
