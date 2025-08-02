<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Contact Inquiries Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#inquiryModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Inquiry
    </button>
</div>

<!-- Contact Inquiries Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Contact Inquiries</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="inquiriesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Replied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Michael Brown</td>
                        <td>michael@example.com</td>
                        <td>Website Development</td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#inquiryModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-reply"></i> Mark as Replied
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sarah Johnson</td>
                        <td>sarah@example.com</td>
                        <td>Digital Marketing</td>
                        <td><span class="badge badge-info">In Progress</span></td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#inquiryModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-reply"></i> Mark as Replied
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>David Wilson</td>
                        <td>david@example.com</td>
                        <td>Mobile App Development</td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#inquiryModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-reply"></i> Mark as Replied
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

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryModalLabel">Contact Inquiry Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="inquiryName">Name</label>
                        <input type="text" class="form-control" id="inquiryName" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="inquiryEmail">Email</label>
                        <input type="email" class="form-control" id="inquiryEmail" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="inquiryPhone">Phone</label>
                        <input type="text" class="form-control" id="inquiryPhone" placeholder="Enter phone">
                    </div>
                    <div class="form-group">
                        <label for="inquiryServiceId">Service</label>
                        <select class="form-control" id="inquiryServiceId">
                            <option value="1">Website Development</option>
                            <option value="2">Mobile App Development</option>
                            <option value="3">E-commerce Solution</option>
                            <option value="4">Digital Marketing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inquiryMessage">Message</label>
                        <textarea class="form-control" id="inquiryMessage" rows="4" placeholder="Enter message"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inquiryStatus">Status</label>
                        <select class="form-control" id="inquiryStatus">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="inquiryReplied">
                        <label class="form-check-label" for="inquiryReplied">Mark as Replied</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Inquiry</button>
            </div>
        </div>
    </div>
</div>
