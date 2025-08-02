<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Team Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#teamModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Team Member
    </button>
</div>

<!-- Team Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Team Members</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="teamTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Skills</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmad Rizal</td>
                        <td>Full Stack Developer</td>
                        <td>PHP, JavaScript, React</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#teamModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Budi Santoso</td>
                        <td>UI/UX Designer</td>
                        <td>Figma, Adobe XD, Photoshop</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#teamModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Citra Dewi</td>
                        <td>Project Manager</td>
                        <td>Agile, Scrum, Team Leadership</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#teamModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Team Member Modal -->
<div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teamModalLabel">Team Member Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="teamName">Full Name</label>
                        <input type="text" class="form-control" id="teamName" placeholder="Enter full name">
                    </div>
                    <div class="form-group">
                        <label for="teamPosition">Position</label>
                        <input type="text" class="form-control" id="teamPosition" placeholder="Enter position">
                    </div>
                    <div class="form-group">
                        <label for="teamBio">Bio</label>
                        <textarea class="form-control" id="teamBio" rows="3" placeholder="Enter bio"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="teamEmail">Email</label>
                        <input type="email" class="form-control" id="teamEmail" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="teamPhone">Phone</label>
                        <input type="text" class="form-control" id="teamPhone" placeholder="Enter phone number">
                    </div>
                    <div class="form-group">
                        <label for="teamImage">Profile Image URL</label>
                        <input type="url" class="form-control" id="teamImage" placeholder="Enter image URL">
                    </div>
                    <div class="form-group">
                        <label for="teamSkills">Skills (JSON array)</label>
                        <textarea class="form-control" id="teamSkills" rows="3" placeholder='["PHP", "JavaScript", "React"]'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="teamSocialLinks">Social Links (JSON object)</label>
                        <textarea class="form-control" id="teamSocialLinks" rows="3" placeholder='{"twitter": "url", "linkedin": "url", "github": "url"}'></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Team Member</button>
            </div>
        </div>
    </div>
</div>
