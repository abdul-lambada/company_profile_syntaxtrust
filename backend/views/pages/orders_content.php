<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Orders Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#orderModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Order
    </button>
</div>

<!-- Orders Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ORD-001</td>
                        <td>John Doe</td>
                        <td>Website Development</td>
                        <td><span class="badge badge-info">In Progress</span></td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td>IDR 299,000</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>ORD-002</td>
                        <td>Jane Smith</td>
                        <td>Mobile App Development</td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td><span class="badge badge-success">Paid</span></td>
                        <td>IDR 599,000</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>ORD-003</td>
                        <td>Robert Johnson</td>
                        <td>E-commerce Solution</td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td>IDR 799,000</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderModal">
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

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="orderNumber">Order Number</label>
                        <input type="text" class="form-control" id="orderNumber" placeholder="Enter order number">
                    </div>
                    <div class="form-group">
                        <label for="orderCustomerName">Customer Name</label>
                        <input type="text" class="form-control" id="orderCustomerName" placeholder="Enter customer name">
                    </div>
                    <div class="form-group">
                        <label for="orderCustomerEmail">Customer Email</label>
                        <input type="email" class="form-control" id="orderCustomerEmail" placeholder="Enter customer email">
                    </div>
                    <div class="form-group">
                        <label for="orderCustomerPhone">Customer Phone</label>
                        <input type="text" class="form-control" id="orderCustomerPhone" placeholder="Enter customer phone">
                    </div>
                    <div class="form-group">
                        <label for="orderServiceId">Service</label>
                        <select class="form-control" id="orderServiceId">
                            <option value="1">Website Development</option>
                            <option value="2">Mobile App Development</option>
                            <option value="3">E-commerce Solution</option>
                            <option value="4">Digital Marketing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orderStatus">Status</label>
                        <select class="form-control" id="orderStatus">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orderPaymentStatus">Payment Status</label>
                        <select class="form-control" id="orderPaymentStatus">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orderTotalAmount">Total Amount</label>
                        <input type="number" class="form-control" id="orderTotalAmount" placeholder="Enter total amount">
                    </div>
                    <div class="form-group">
                        <label for="orderRequirements">Requirements (JSON)</label>
                        <textarea class="form-control" id="orderRequirements" rows="4" placeholder='{"requirement1": "value1", "requirement2": "value2"}'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="orderNotes">Notes</label>
                        <textarea class="form-control" id="orderNotes" rows="3" placeholder="Enter notes"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Order</button>
            </div>
        </div>
    </div>
</div>
