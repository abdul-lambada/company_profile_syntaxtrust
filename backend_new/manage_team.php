<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get team data
try {
    $stmt = $pdo->query("SELECT * FROM team WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC");
    $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $team = [];
}

$page_title = 'Manage Team - SyntaxTrust';
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
        <h1 class="h3 mb-0 text-gray-800">Manage Team</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addTeamModal">
            <i class="fas fa-plus"></i> Add New Member
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Team Members</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="teamTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Experience</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($team as $member): ?>
                                <tr>
                                    <td><?php echo $member['id']; ?></td>
                                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['position']); ?></td>
                                    <td><?php echo htmlspecialchars($member['email']); ?></td>
                                    <td><?php echo htmlspecialchars($member['phone']); ?></td>
                                    <td><?php echo $member['experience_years']; ?> years</td>
                                    <td><?php echo $member['sort_order']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-team" data-id="<?php echo $member['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-team" data-id="<?php echo $member['id']; ?>">
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

<!-- Add Team Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeamModalLabel">Add New Team Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTeamForm">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="linkedin_url">LinkedIn URL</label>
                            <input type="url" class="form-control" id="linkedin_url" name="linkedin_url">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="github_url">GitHub URL</label>
                            <input type="url" class="form-control" id="github_url" name="github_url">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="twitter_url">Twitter URL</label>
                            <input type="url" class="form-control" id="twitter_url" name="twitter_url">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="profile_image">Profile Image URL</label>
                            <input type="url" class="form-control" id="profile_image" name="profile_image">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="experience_years">Experience (years)</label>
                            <input type="number" class="form-control" id="experience_years" name="experience_years" min="0" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="skills">Skills (comma separated)</label>
                        <input type="text" class="form-control" id="skills" name="skills" placeholder="PHP, JavaScript, React, Node.js">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Member</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Add Team Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamModalLabel">Add New Team Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addTeamForm">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="linkedin_url">LinkedIn URL</label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="github_url">GitHub URL</label>
                                <input type="url" class="form-control" id="github_url" name="github_url">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="twitter_url">Twitter URL</label>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="profile_image">Profile Image URL</label>
                                <input type="url" class="form-control" id="profile_image" name="profile_image">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="experience_years">Experience (years)</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years" min="0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="skills">Skills (comma separated)</label>
                            <input type="text" class="form-control" id="skills" name="skills" placeholder="PHP, JavaScript, React, Node.js">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#teamTable').DataTable();

        // Add Team Form
        $('#addTeamForm').on('submit', function(e) {
            e.preventDefault();
            
            var skills = $('#skills').val().split(',').map(function(item) {
                return item.trim();
            });
            
            $.ajax({
                url: 'api/team.php',
                type: 'POST',
                data: JSON.stringify({
                    name: $('#name').val(),
                    position: $('#position').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    bio: $('#bio').val(),
                    linkedin_url: $('#linkedin_url').val(),
                    github_url: $('#github_url').val(),
                    twitter_url: $('#twitter_url').val(),
                    profile_image: $('#profile_image').val(),
                    experience_years: parseInt($('#experience_years').val()),
                    sort_order: parseInt($('#sort_order').val()),
                    skills: skills
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        alert('Team member added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding team member: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error adding team member');
                }
            });
        });

        // Edit Team
        $('.edit-team').on('click', function() {
            var teamId = $(this).data('id');
            // Implement edit functionality
            alert('Edit functionality for team member ID: ' + teamId);
        });

        // Delete Team
        $('.delete-team').on('click', function() {
            var teamId = $(this).data('id');
            if (confirm('Are you sure you want to delete this team member?')) {
                $.ajax({
                    url: 'api/team.php?id=' + teamId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert('Team member deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error deleting team member: ' + response.error);
                        }
                    },
                    error: function() {
                        alert('Error deleting team member');
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
<?php include 'includes/footer.php'; ?>

<!-- Footer Duplicate Removed -->
    </div>
    <!-- End of Page Wrapper -->

    <?php require_once 'includes/scripts.php'; ?>

</body>