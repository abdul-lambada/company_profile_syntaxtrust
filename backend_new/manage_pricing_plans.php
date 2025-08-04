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

// Delete pricing plan
if (isset($_POST['delete_plan']) && isset($_POST['plan_id'])) {
    $plan_id = $_POST['plan_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM pricing_plans WHERE id = ?");
        $stmt->execute([$plan_id]);
        $message = "Pricing plan deleted successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error deleting pricing plan: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle plan status
if (isset($_POST['toggle_status']) && isset($_POST['plan_id'])) {
    $plan_id = $_POST['plan_id'];
    try {
        $stmt = $pdo->prepare("UPDATE pricing_plans SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$plan_id]);
        $message = "Pricing plan status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating pricing plan status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Toggle popular status
if (isset($_POST['toggle_popular']) && isset($_POST['plan_id'])) {
    $plan_id = $_POST['plan_id'];
    try {
        $stmt = $pdo->prepare("UPDATE pricing_plans SET is_popular = NOT is_popular WHERE id = ?");
        $stmt->execute([$plan_id]);
        $message = "Popular status updated successfully!";
        $message_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating popular status: " . $e->getMessage();
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
    $where_clause = "WHERE name LIKE ? OR subtitle LIKE ? OR description LIKE ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param];
}

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM pricing_plans $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Get pricing plans with pagination
$sql = "SELECT * FROM pricing_plans $where_clause ORDER BY sort_order ASC, created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pricing_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1 class="h3 mb-0 text-gray-800">Manage Pricing Plans</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addPlanModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Plan
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
                            <h6 class="m-0 font-weight-bold text-primary">Search Pricing Plans</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="Search by name, subtitle..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                                <?php if (!empty($search)): ?>
                                    <a href="manage_pricing_plans.php" class="btn btn-secondary mb-2 ml-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Pricing Plans Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pricing Plans List (<?php echo $total_records; ?> total)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Subtitle</th>
                                            <th>Price</th>
                                            <th>Billing Period</th>
                                            <th>Status</th>
                                            <th>Popular</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pricing_plans as $plan): ?>
                                            <tr>
                                                <td><?php echo $plan['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($plan['name']); ?></strong>
                                                    <?php if (!empty($plan['icon'])): ?>
                                                        <br><small class="text-muted"><i class="fas fa-<?php echo htmlspecialchars($plan['icon']); ?>"></i></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($plan['subtitle'] ?? ''); ?></td>
                                                <td>
                                                    <?php if ($plan['price'] > 0): ?>
                                                        <?php echo $plan['currency']; ?> <?php echo number_format($plan['price'], 0, ',', '.'); ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">Custom</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?php echo ucfirst(str_replace('_', ' ', $plan['billing_period'])); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $plan['is_active'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $plan['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $plan['is_popular'] ? 'warning' : 'light'; ?>">
                                                        <?php echo $plan['is_popular'] ? 'Popular' : 'Regular'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewPlanModal<?php echo $plan['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPlanModal<?php echo $plan['id']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle this plan\'s status?')">
                                                            <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
                                                            <button type="submit" name="toggle_status" class="btn btn-sm btn-<?php echo $plan['is_active'] ? 'warning' : 'success'; ?>">
                                                                <i class="fas fa-<?php echo $plan['is_active'] ? 'ban' : 'check'; ?>"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to toggle popular status?')">
                                                            <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
                                                            <button type="submit" name="toggle_popular" class="btn btn-sm btn-<?php echo $plan['is_popular'] ? 'secondary' : 'warning'; ?>">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this pricing plan? This action cannot be undone.')">
                                                            <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
                                                            <button type="submit" name="delete_plan" class="btn btn-sm btn-danger">
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
