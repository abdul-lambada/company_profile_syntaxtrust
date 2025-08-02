<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Portfolio Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm add-portfolio-btn">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Portfolio Item
    </button>
</div>

<!-- Portfolio Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Portfolio Items</h6>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>E-commerce Website for Fashion Brand</td>
                        <td>FashionStyle Inc.</td>
                        <td>Web Development</td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-portfolio-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-portfolio-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Mobile Banking App</td>
                        <td>SecureBank</td>
                        <td>Mobile App</td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-portfolio-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-portfolio-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Corporate Branding Package</td>
                        <td>TechGlobal Ltd.</td>
                        <td>Branding</td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-portfolio-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-portfolio-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Portfolio Modal -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="portfolioModalLabel">Portfolio Item Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="portfolioForm">
                    <input type="hidden" id="portfolioId">
                    <div class="form-group">
                        <label for="portfolioTitle">Project Title</label>
                        <input type="text" class="form-control" id="portfolioTitle" placeholder="Enter project title">
                    </div>
                    <div class="form-group">
                        <label for="portfolioDescription">Description</label>
                        <textarea class="form-control" id="portfolioDescription" rows="3" placeholder="Enter project description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="portfolioShortDescription">Short Description</label>
                        <input type="text" class="form-control" id="portfolioShortDescription" placeholder="Enter short description">
                    </div>
                    <div class="form-group">
                        <label for="portfolioClient">Client Name</label>
                        <input type="text" class="form-control" id="portfolioClient" placeholder="Enter client name">
                    </div>
                    <div class="form-group">
                        <label for="portfolioCategory">Category</label>
                        <select class="form-control" id="portfolioCategory">
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="Branding">Branding</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="portfolioTechnologies">Technologies (JSON array)</label>
                        <textarea class="form-control" id="portfolioTechnologies" rows="3" placeholder='["HTML", "CSS", "JavaScript", "PHP"]'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="portfolioProjectUrl">Project URL</label>
                        <input type="url" class="form-control" id="portfolioProjectUrl" placeholder="Enter project URL">
                    </div>
                    <div class="form-group">
                        <label for="portfolioGithubUrl">GitHub URL</label>
                        <input type="url" class="form-control" id="portfolioGithubUrl" placeholder="Enter GitHub URL">
                    </div>
                    <div class="form-group">
                        <label for="portfolioImageMain">Main Image URL</label>
                        <input type="url" class="form-control" id="portfolioImageMain" placeholder="Enter main image URL">
                    </div>
                    <div class="form-group">
                        <label for="portfolioImages">Additional Images (JSON array)</label>
                        <textarea class="form-control" id="portfolioImages" rows="3" placeholder='["image1.jpg", "image2.jpg", "image3.jpg"]'></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="portfolioStartDate">Start Date</label>
                            <input type="date" class="form-control" id="portfolioStartDate">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="portfolioEndDate">End Date</label>
                            <input type="date" class="form-control" id="portfolioEndDate">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="portfolioStatus">Status</label>
                        <select class="form-control" id="portfolioStatus">
                            <option value="completed">Completed</option>
                            <option value="in_progress">In Progress</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="portfolioFeatured">
                        <label class="form-check-label" for="portfolioFeatured">Featured Project</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Portfolio Item</button>
            </div>
        </div>
    </div>
</div>
