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

// Delete inquiry
if (isset($_POST['delete_inquiry']) && isset($_POST['inquiry_id'])) {
    $inquiry_id = $_POST['inquiry_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM contact_inquiries WHERE id = ?");
        $stmt->execute([$inquiry_id]);
        $message = "Contact inquiry deleted successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error deleting contact inquiry: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Update inquiry status
if (isset($_POST['update_status']) && isset($_POST['inquiry_id']) && isset($_POST['status'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $status = $_POST['status'];
    try {
        $stmt = $pdo->prepare("UPDATE contact_inquiries SET status = ? WHERE id = ?");
        $stmt->execute([$status, $inquiry_id]);
        $message = "Inquiry status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating inquiry status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Search and pagination
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Build query
$where_conditions = [];
$params = [];

if (!empty($search)) {
    $where_conditions[] = "(name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
}

if (!empty($status_filter)) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM contact_inquiries $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Get inquiries with pagination
$sql = "SELECT c.*, s.name as service_name 
        FROM contact_inquiries c 
        LEFT JOIN services s ON c.service_id = s.id 
        $where_clause 
        ORDER BY c.created_at DESC 
        LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1 class="h3 mb-0 text-gray-800">Manage Contact Inquiries</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addInquiryModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Inquiry
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

                    <!-- Search and Filter Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Search and Filter Inquiries</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="Search by name, email, subject..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <select class="form-control" name="status">
                                        <option value="">All Status</option>
                                        <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                                        <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                                        <option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                        <option value="closed" <?php echo $status_filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                                <?php if (!empty($search) || !empty($status_filter)): ?>
                                    <a href="manage_contact_inquiries.php" class="btn btn-secondary mb-2 ml-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Inquiries Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Contact Inquiries List (<?php echo $total_records; ?> total)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Contact Info</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($inquiries as $inquiry): ?>
                                            <tr>
                                                <td><?php echo $inquiry['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars($inquiry['email']); ?></small>
                                                    <?php if (!empty($inquiry['phone'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($inquiry['phone']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($inquiry['subject'] ?? 'No Subject'); ?>
                                                    <?php if (!empty($inquiry['budget_range'])): ?>
                                                        <br><small class="text-info">Budget: <?php echo htmlspecialchars($inquiry['budget_range']); ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($inquiry['timeline'])): ?>
                                                        <br><small class="text-info">Timeline: <?php echo htmlspecialchars($inquiry['timeline']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(substr($inquiry['message'], 0, 150) . '...'); ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($inquiry['service_name'])): ?>
                                                        <span class="badge badge-info"><?php echo htmlspecialchars($inquiry['service_name']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">General</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php 
                                                        echo $inquiry['status'] === 'new' ? 'danger' : 
                                                            ($inquiry['status'] === 'read' ? 'warning' : 
                                                            ($inquiry['status'] === 'replied' ? 'success' : 'secondary')); 
                                                    ?>">
                                                        <?php echo ucfirst($inquiry['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php echo date('d M Y H:i', strtotime($inquiry['created_at'])); ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewInquiryModal<?php echo $inquiry['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editInquiryModal<?php echo $inquiry['id']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                                                Status
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                                    <input type="hidden" name="status" value="new">
                                                                    <button type="submit" name="update_status" class="dropdown-item">New</button>
                                                                </form>
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                                    <input type="hidden" name="status" value="read">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Read</button>
                                                                </form>
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                                    <input type="hidden" name="status" value="replied">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Replied</button>
                                                                </form>
                                                                <form method="POST" style="display: inline;">
                                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                                    <input type="hidden" name="status" value="closed">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Closed</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')">
                                                            <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                            <button type="submit" name="delete_inquiry" class="btn btn-sm btn-danger">
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
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">Previous</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">Next</a>
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
