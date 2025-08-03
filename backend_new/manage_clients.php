<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get clients data
try {
    $stmt = $pdo->query("SELECT * FROM clients WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $clients = [];
}

$page_title = 'Manage Clients - SyntaxTrust';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Clients</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addClientModal">
            <i class="fas fa-plus"></i> Add New Client
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Clients List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="clientsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th>Rating</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?php echo $client['id']; ?></td>
                                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                                    <td>
                                        <?php if ($client['logo']): ?>
                                        <img src="<?php echo htmlspecialchars($client['logo']); ?>" alt="<?php echo htmlspecialchars($client['name']); ?>" style="max-height: 50px;">
                                        <?php else: ?>
                                        <span class="text-muted">No Logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($client['website_url']): ?>
                                        <a href="<?php echo htmlspecialchars($client['website_url']); ?>" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php else: ?>
                                        <span class="text-muted">No Website</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $client['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                    <td><?php echo $client['sort_order']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-client" data-id="<?php echo $client['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-client" data-id="<?php echo $client['id']; ?>">
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

<!-- Add Client Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addClientForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Client Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="website_url">Website URL</label>
                            <input type="url" class="form-control" id="website_url" name="website_url">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="logo">Logo URL</label>
                            <input type="url" class="form-control" id="logo" name="logo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="testimonial">Testimonial</label>
                            <textarea class="form-control" id="testimonial" name="testimonial" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rating">Rating</label>
                            <select class="form-control" id="rating" name="rating" required>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Client</button>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#clientsTable').DataTable();

        // Add Client Form
        $('#addClientForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'api/clients.php',
                type: 'POST',
                data: JSON.stringify({
                    name: $('#name').val(),
                    logo: $('#logo').val(),
                    website: $('#website').val(),
                    industry: $('#industry').val(),
                    description: $('#description').val(),
                    is_active: parseInt($('#is_active').val()),
                    sort_order: parseInt($('#sort_order').val())
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        alert('Client added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding client: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error adding client');
                }
            });
        });

        // Edit Client
        $('.edit-client').on('click', function() {
            var clientId = $(this).data('id');
            // Implement edit functionality
            alert('Edit functionality for client ID: ' + clientId);
        });

        // Delete Client
        $('.delete-client').on('click', function() {
            var clientId = $(this).data('id');
            if (confirm('Are you sure you want to delete this client?')) {
                $.ajax({
                    url: 'api/clients.php?id=' + clientId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert('Client deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error deleting client: ' + response.error);
                        }
                    },
                    error: function() {
                        alert('Error deleting client');
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
                <!-- End of Footer -->
                
            </div>
            <!-- End of Content Wrapper -->
            
            <?php require_once 'includes/footer.php'; ?>
    </div>
    <!-- End of Page Wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
