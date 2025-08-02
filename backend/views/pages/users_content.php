<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#userModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New User
    </button>
</div>

<!-- Users Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Admin User</td>
                        <td>admin@syntaxtrust.com</td>
                        <td>Administrator</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#userModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Content Manager</td>
                        <td>manager@syntaxtrust.com</td>
                        <td>Manager</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#userModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Editor User</td>
                        <td>editor@syntaxtrust.com</td>
                        <td>Editor</td>
                        <td><span class="badge badge-secondary">Inactive</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#userModal">
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

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="userName">Full Name</label>
                        <input type="text" class="form-control" id="userName" placeholder="Enter full name">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role</label>
                        <select class="form-control" id="userRole">
                            <option value="administrator">Administrator</option>
                            <option value="manager">Manager</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" class="form-control" id="userPassword" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="userConfirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="userConfirmPassword" placeholder="Confirm password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="userActive" checked>
                        <label class="form-check-label" for="userActive">Active User</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save User</button>
            </div>
        </div>
    </div>
</div>
