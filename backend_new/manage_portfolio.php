<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get portfolio data
try {
    $stmt = $pdo->query("SELECT * FROM portfolio WHERE is_active = 1 ORDER BY created_at DESC");
    $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $portfolio = [];
}

$page_title = 'Manage Portfolio - SyntaxTrust';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Portfolio</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addPortfolioModal">
            <i class="fas fa-plus"></i> Add New Portfolio
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Portfolio Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="portfolioTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Client</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($portfolio as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td><?php echo htmlspecialchars($item['client_name']); ?></td>
                                    <td>
                                        <span class="badge badge-info"><?php echo htmlspecialchars($item['category']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $item['status'] == 'completed' ? 'success' : ($item['status'] == 'in_progress' ? 'warning' : 'secondary'); ?>">
                                            <?php echo ucfirst($item['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $item['is_featured'] ? 'success' : 'secondary'; ?>">
                                            <?php echo $item['is_featured'] ? 'Yes' : 'No'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($item['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-portfolio" data-id="<?php echo $item['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-portfolio" data-id="<?php echo $item['id']; ?>">
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

<!-- Add Portfolio Modal -->
<div class="modal fade" id="addPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPortfolioModalLabel">Add New Portfolio Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPortfolioForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="client_name">Client Name</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="web">Web Development</option>
                                <option value="mobile">Mobile App</option>
                                <option value="design">UI/UX Design</option>
                                <option value="branding">Branding</option>
                                <option value="marketing">Digital Marketing</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="planning">Planning</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Full Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="project_url">Project URL</label>
                            <input type="url" class="form-control" id="project_url" name="project_url">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="github_url">GitHub URL</label>
                            <input type="url" class="form-control" id="github_url" name="github_url">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="is_featured">Featured</label>
                            <select class="form-control" id="is_featured" name="is_featured">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_main">Main Image URL</label>
                        <input type="url" class="form-control" id="image_main" name="image_main" required>
                    </div>
                    <div class="form-group">
                        <label for="technologies">Technologies (comma separated)</label>
                        <input type="text" class="form-control" id="technologies" name="technologies" placeholder="HTML, CSS, JavaScript, PHP">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Portfolio</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Add Portfolio Modal -->
    <div class="modal fade" id="addPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPortfolioModalLabel">Add New Portfolio Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addPortfolioForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Project Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="web">Web Development</option>
                                    <option value="mobile">Mobile App</option>
                                    <option value="design">UI/UX Design</option>
                                    <option value="branding">Branding</option>
                                    <option value="marketing">Digital Marketing</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="planning">Planning</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Full Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="project_url">Project URL</label>
                                <input type="url" class="form-control" id="project_url" name="project_url">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="github_url">GitHub URL</label>
                                <input type="url" class="form-control" id="github_url" name="github_url">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="is_featured">Featured</label>
                                <select class="form-control" id="is_featured" name="is_featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image_main">Main Image URL</label>
                            <input type="url" class="form-control" id="image_main" name="image_main" required>
                        </div>
                        <div class="form-group">
                            <label for="technologies">Technologies (comma separated)</label>
                            <input type="text" class="form-control" id="technologies" name="technologies" placeholder="HTML, CSS, JavaScript, PHP">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Portfolio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#portfolioTable').DataTable();

        // Add Portfolio Form
        $('#addPortfolioForm').on('submit', function(e) {
            e.preventDefault();
            
            var technologies = $('#technologies').val().split(',').map(function(item) {
                return item.trim();
            });
            
            $.ajax({
                url: 'api/portfolio.php',
                type: 'POST',
                data: JSON.stringify({
                    title: $('#title').val(),
                    client_name: $('#client_name').val(),
                    category: $('#category').val(),
                    short_description: $('#short_description').val(),
                    description: $('#description').val(),
                    project_url: $('#project_url').val(),
                    github_url: $('#github_url').val(),
                    image_main: $('#image_main').val(),
                    technologies: technologies,
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val() || null,
                    status: $('#status').val(),
                    is_featured: parseInt($('#is_featured').val())
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        alert('Portfolio item added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding portfolio: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error adding portfolio');
                }
            });
        });

        // Edit Portfolio
        $('.edit-portfolio').on('click', function() {
            var portfolioId = $(this).data('id');
            // Implement edit functionality
            alert('Edit functionality for portfolio ID: ' + portfolioId);
        });

        // Delete Portfolio
        $('.delete-portfolio').on('click', function() {
            var portfolioId = $(this).data('id');
            if (confirm('Are you sure you want to delete this portfolio item?')) {
                $.ajax({
                    url: 'api/portfolio.php?id=' + portfolioId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert('Portfolio item deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error deleting portfolio: ' + response.error);
                        }
                    },
                    error: function() {
                        alert('Error deleting portfolio');
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

                <!-- Footer Duplicate Removed -->
                
            </div>
            <!-- End of Content Wrapper -->
            <?php include 'includes/footer.php'; ?>

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
