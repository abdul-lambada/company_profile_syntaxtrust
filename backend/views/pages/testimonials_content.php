<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Testimonials Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#testimonialModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Testimonial
    </button>
</div>

<!-- Testimonials Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Testimonials</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="testimonialsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Company</th>
                        <th>Content</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>CEO</td>
                        <td>FashionStyle Inc.</td>
                        <td>Working with SyntaxTrust was an excellent experience. They delivered our e-commerce website on time and exceeded our expectations in terms of quality and functionality.</td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#testimonialModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Marketing Director</td>
                        <td>SecureBank</td>
                        <td>The mobile banking app developed by SyntaxTrust has significantly improved our customer engagement. Their team was professional and responsive throughout the project.</td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#testimonialModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Robert Johnson</td>
                        <td>CTO</td>
                        <td>TechGlobal Ltd.</td>
                        <td>SyntaxTrust provided us with a comprehensive branding solution that has helped us establish a strong market presence. Highly recommended for any business looking for quality IT services.</td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#testimonialModal">
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

<!-- Testimonial Modal -->
<div class="modal fade" id="testimonialModal" tabindex="-1" role="dialog" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testimonialModalLabel">Testimonial Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="testimonialName">Client Name</label>
                        <input type="text" class="form-control" id="testimonialName" placeholder="Enter client name">
                    </div>
                    <div class="form-group">
                        <label for="testimonialPosition">Position</label>
                        <input type="text" class="form-control" id="testimonialPosition" placeholder="Enter position">
                    </div>
                    <div class="form-group">
                        <label for="testimonialCompany">Company</label>
                        <input type="text" class="form-control" id="testimonialCompany" placeholder="Enter company">
                    </div>
                    <div class="form-group">
                        <label for="testimonialContent">Testimonial Content</label>
                        <textarea class="form-control" id="testimonialContent" rows="4" placeholder="Enter testimonial content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="testimonialImage">Client Image URL</label>
                        <input type="url" class="form-control" id="testimonialImage" placeholder="Enter image URL">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="testimonialFeatured">
                        <label class="form-check-label" for="testimonialFeatured">Featured Testimonial</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Testimonial</button>
            </div>
        </div>
    </div>
</div>
