<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get settings data
try {
    $stmt = $pdo->query("SELECT * FROM settings ORDER BY setting_key ASC");
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $settings = [];
}

$page_title = 'Manage Settings - SyntaxTrust';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Settings</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addSettingModal">
            <i class="fas fa-plus"></i> Add New Setting
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Settings List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="settingsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($settings as $setting): ?>
                                <tr>
                                    <td><?php echo $setting['id']; ?></td>
                                    <td><?php echo htmlspecialchars($setting['setting_key']); ?></td>
                                    <td>
                                        <?php if (strlen($setting['setting_value']) > 50): ?>
                                        <?php echo htmlspecialchars(substr($setting['setting_value'], 0, 50)) . '...'; ?>
                                        <?php else: ?>
                                        <?php echo htmlspecialchars($setting['setting_value']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($setting['description']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $setting['setting_type'] == 'text' ? 'info' : ($setting['setting_type'] == 'boolean' ? 'success' : 'warning'); ?>">
                                            <?php echo ucfirst($setting['setting_type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-setting" data-id="<?php echo $setting['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-setting" data-id="<?php echo $setting['id']; ?>">
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

<!-- Add Setting Modal -->
<div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog" aria-labelledby="addSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSettingModalLabel">Add New Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSettingForm">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="setting_key">Setting Key</label>
                            <input type="text" class="form-control" id="setting_key" name="setting_key" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="setting_type">Type</label>
                            <select class="form-control" id="setting_type" name="setting_type" required>
                                <option value="text">Text</option>
                                <option value="boolean">Boolean</option>
                                <option value="number">Number</option>
                                <option value="json">JSON</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="setting_value">Value</label>
                        <textarea class="form-control" id="setting_value" name="setting_value" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
include 'includes/scripts.php';
?>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#settingsTable').DataTable();

    // Add Setting Form
    $('#addSettingForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'api/settings.php',
            type: 'POST',
            data: JSON.stringify({
                setting_key: $('#setting_key').val(),
                setting_value: $('#setting_value').val(),
                description: $('#description').val(),
                is_public: parseInt($('#is_public').val()),
                setting_group: $('#setting_group').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    alert('Setting added successfully!');
                    location.reload();
                } else {
                    alert('Error adding setting: ' + response.error);
                }
            },
            error: function() {
                alert('Error adding setting');
            }
        });
    });

    // Edit Setting
    $('.edit-setting').on('click', function() {
        var settingId = $(this).data('id');
        // Implement edit functionality
        alert('Edit functionality for setting ID: ' + settingId);
    });

    // Delete Setting
    $('.delete-setting').on('click', function() {
        var settingId = $(this).data('id');
        if (confirm('Are you sure you want to delete this setting?')) {
            $.ajax({
                url: 'api/settings.php?id=' + settingId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert('Setting deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting setting: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error deleting setting');
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

                <!-- Footer -->
            <?php require_once 'includes/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
