<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get services data
try {
    $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $services = [];
}

$page_title = 'Manage Services - SyntaxTrust';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Services</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addServiceModal">
            <i class="fas fa-plus"></i> Add New Service
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Services List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="servicesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Featured</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo $service['id']; ?></td>
                                    <td><?php echo htmlspecialchars($service['name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($service['description'], 0, 100)) . '...'; ?></td>
                                    <td>Rp <?php echo number_format($service['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $service['is_featured'] ? 'success' : 'secondary'; ?>">
                                            <?php echo $service['is_featured'] ? 'Yes' : 'No'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $service['sort_order']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-service" data-id="<?php echo $service['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-service" data-id="<?php echo $service['id']; ?>">
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addServiceForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Service Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Full Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon (Font Awesome)</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="fas fa-cog">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="is_featured">Featured</label>
                            <select class="form-control" id="is_featured" name="is_featured">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <?php include 'includes/footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addServiceForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Service Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Full Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon (Font Awesome)</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="fas fa-cog">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="is_featured">Featured</label>
                                <select class="form-control" id="is_featured" name="is_featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#servicesTable').DataTable();

        // Add Service Form
        $('#addServiceForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'api/services.php',
                type: 'POST',
                data: JSON.stringify({
                    name: $('#name').val(),
                    short_description: $('#short_description').val(),
                    description: $('#description').val(),
                    icon: $('#icon').val(),
                    price: $('#price').val(),
                    is_featured: parseInt($('#is_featured').val()),
                    sort_order: parseInt($('#sort_order').val())
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        alert('Service added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding service: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error adding service');
                }
            });
        });

        // Edit Service
        $('.edit-service').on('click', function() {
            var serviceId = $(this).data('id');
            // Implement edit functionality
            alert('Edit functionality for service ID: ' + serviceId);
        });

        // Delete Service
        $('.delete-service').on('click', function() {
            var serviceId = $(this).data('id');
            if (confirm('Are you sure you want to delete this service?')) {
                $.ajax({
                    url: 'api/services.php?id=' + serviceId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert('Service deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error deleting service: ' + response.error);
                        }
                    },
                    error: function() {
                        alert('Error deleting service');
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
