<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Services Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm add-service-btn">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Service
    </button>
</div>

<!-- Services Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Services</h6>
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
                        <th>Duration</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Website Development</td>
                        <td>Pengembangan website profesional untuk bisnis Anda dengan teknologi modern dan responsive design.</td>
                        <td>IDR 299,000</td>
                        <td>2-4 weeks</td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-service-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-service-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Mobile App Development</td>
                        <td>Aplikasi mobile native dan cross-platform untuk iOS dan Android dengan performa optimal.</td>
                        <td>IDR 599,000</td>
                        <td>4-8 weeks</td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-service-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-service-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>E-commerce Solution</td>
                        <td>Platform e-commerce lengkap dengan payment gateway dan sistem manajemen produk.</td>
                        <td>IDR 799,000</td>
                        <td>6-10 weeks</td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-service-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-service-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Digital Marketing</td>
                        <td>Strategi digital marketing komprehensif untuk meningkatkan brand awareness dan penjualan.</td>
                        <td>IDR 199,000</td>
                        <td>Ongoing</td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm edit-service-btn" data-id="1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-service-btn" data-id="1">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="serviceForm">
                    <input type="hidden" id="serviceId">
                    <div class="form-group">
                        <label for="serviceName">Service Name</label>
                        <input type="text" class="form-control" id="serviceName" placeholder="Enter service name">
                    </div>
                    <div class="form-group">
                        <label for="serviceDescription">Description</label>
                        <textarea class="form-control" id="serviceDescription" rows="3" placeholder="Enter service description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="serviceShortDescription">Short Description</label>
                        <input type="text" class="form-control" id="serviceShortDescription" placeholder="Enter short description">
                    </div>
                    <div class="form-group">
                        <label for="serviceIcon">Icon</label>
                        <input type="text" class="form-control" id="serviceIcon" placeholder="Enter icon name">
                    </div>
                    <div class="form-group">
                        <label for="servicePrice">Price</label>
                        <input type="number" class="form-control" id="servicePrice" placeholder="Enter price">
                    </div>
                    <div class="form-group">
                        <label for="serviceDuration">Duration</label>
                        <input type="text" class="form-control" id="serviceDuration" placeholder="Enter duration">
                    </div>
                    <div class="form-group">
                        <label for="serviceFeatures">Features (JSON array)</label>
                        <textarea class="form-control" id="serviceFeatures" rows="3" placeholder='["Feature 1", "Feature 2", "Feature 3"]'></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="serviceFeatured">
                        <label class="form-check-label" for="serviceFeatured">Featured Service</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Service</button>
            </div>
        </div>
    </div>
</div>
