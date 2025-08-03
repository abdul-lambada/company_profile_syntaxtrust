<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get users data
try {
    $stmt = $pdo->query("SELECT * FROM users WHERE is_active = 1 ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
}

$page_title = 'Manage Users - SyntaxTrust';
include 'includes/header.php';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Users</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-plus"></i> Add New User
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $user['user_type'] == 'admin' ? 'danger' : 'info'; ?>">
                                            <?php echo ucfirst($user['user_type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $user['is_active'] ? 'success' : 'secondary'; ?>">
                                            <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-user" data-id="<?php echo $user['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-user" data-id="<?php echo $user['id']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="user_type">User Type</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="is_active">Status</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#usersTable').DataTable();

    // Add User Form
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'api/users.php',
            type: 'POST',
            data: JSON.stringify({
                full_name: $('#full_name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val(),
                phone: $('#phone').val(),
                is_active: parseInt($('#is_active').val())
            }),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    alert('User added successfully!');
                    location.reload();
                } else {
                    alert('Error adding user: ' + response.error);
                }
            },
            error: function() {
                alert('Error adding user');
            }
        });
    });

    // Edit User
    $('.edit-user').on('click', function() {
        var userId = $(this).data('id');
        // Implement edit functionality
        alert('Edit functionality for user ID: ' + userId);
    });

    // Delete User
    $('.delete-user').on('click', function() {
        var userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: 'api/users.php?id=' + userId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert('User deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting user: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error deleting user');
                }
            });
        }
    });
});
</script>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    
</div>
<!-- End of Content Wrapper -->

<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>
<!-- End of Footer -->
    </div>
    <!-- End of Page Wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
