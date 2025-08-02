<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Blog Posts Management</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#blogPostModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Blog Post
    </button>
</div>

<!-- Blog Posts Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Blog Posts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="blogPostsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Tags</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Best Practices for Web Development in 2025</td>
                        <td>Ahmad Rizal</td>
                        <td>Web Development</td>
                        <td>web, development, best-practices</td>
                        <td>124</td>
                        <td><span class="badge badge-success">Published</span></td>
                        <td><span class="badge badge-success">Yes</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#blogPostModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Understanding Mobile App Security</td>
                        <td>Budi Santoso</td>
                        <td>Mobile Development</td>
                        <td>mobile, security, apps</td>
                        <td>87</td>
                        <td><span class="badge badge-success">Published</span></td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#blogPostModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>How to Choose the Right IT Partner</td>
                        <td>Citra Dewi</td>
                        <td>Business</td>
                        <td>business, partnership, advice</td>
                        <td>56</td>
                        <td><span class="badge badge-warning">Draft</span></td>
                        <td><span class="badge badge-secondary">No</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#blogPostModal">
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

<!-- Blog Post Modal -->
<div class="modal fade" id="blogPostModal" tabindex="-1" role="dialog" aria-labelledby="blogPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blogPostModalLabel">Blog Post Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="blogPostTitle">Title</label>
                        <input type="text" class="form-control" id="blogPostTitle" placeholder="Enter blog post title">
                    </div>
                    <div class="form-group">
                        <label for="blogPostSlug">Slug</label>
                        <input type="text" class="form-control" id="blogPostSlug" placeholder="Enter slug">
                    </div>
                    <div class="form-group">
                        <label for="blogPostAuthor">Author</label>
                        <input type="text" class="form-control" id="blogPostAuthor" placeholder="Enter author name">
                    </div>
                    <div class="form-group">
                        <label for="blogPostCategory">Category</label>
                        <input type="text" class="form-control" id="blogPostCategory" placeholder="Enter category">
                    </div>
                    <div class="form-group">
                        <label for="blogPostTags">Tags (JSON array)</label>
                        <textarea class="form-control" id="blogPostTags" rows="2" placeholder='["tag1", "tag2", "tag3"]'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="blogPostImage">Featured Image URL</label>
                        <input type="url" class="form-control" id="blogPostImage" placeholder="Enter image URL">
                    </div>
                    <div class="form-group">
                        <label for="blogPostContent">Content</label>
                        <textarea class="form-control" id="blogPostContent" rows="6" placeholder="Enter blog post content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="blogPostExcerpt">Excerpt</label>
                        <textarea class="form-control" id="blogPostExcerpt" rows="3" placeholder="Enter excerpt"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="blogPostStatus">Status</label>
                        <select class="form-control" id="blogPostStatus">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="blogPostFeatured">
                        <label class="form-check-label" for="blogPostFeatured">Featured Post</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Blog Post</button>
            </div>
        </div>
    </div>
</div>
