<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Clients Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#clientModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Client
    </button>
</div>

<!-- Clients Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Clients</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="clientsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>FashionStyle Inc.</td>
                        <td><img src="https://source.unsplash.com/random/100x100?logo" alt="Client Logo" width="50"></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#clientModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>SecureBank</td>
                        <td><img src="https://source.unsplash.com/random/100x100?bank" alt="Client Logo" width="50"></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#clientModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>TechGlobal Ltd.</td>
                        <td><img src="https://source.unsplash.com/random/100x100?tech" alt="Client Logo" width="50"></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#clientModal">
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

<!-- Client Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Client Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="clientName">Client Name</label>
                        <input type="text" class="form-control" id="clientName" placeholder="Enter client name">
                    </div>
                    <div class="form-group">
                        <label for="clientLogo">Logo URL</label>
                        <input type="url" class="form-control" id="clientLogo" placeholder="Enter logo URL">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Client</button>
            </div>
        </div>
    </div>
</div>
