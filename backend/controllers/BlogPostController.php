<?php
require_once '../config/database.php';
require_once '../models/BlogPost.php';

class BlogPostController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all published blog posts
    public function getPublishedBlogPosts() {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getPublished();
            $this->sendResponse($posts, "Published blog posts retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving published blog posts: " . $e->getMessage());
        }
    }
    
    // Get all blog posts (admin)
    public function getAllBlogPosts() {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getAll();
            $this->sendResponse($posts, "All blog posts retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving blog posts: " . $e->getMessage());
        }
    }
    
    // Get featured blog posts
    public function getFeaturedBlogPosts() {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getFeatured();
            $this->sendResponse($posts, "Featured blog posts retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving featured blog posts: " . $e->getMessage());
        }
    }
    
    // Get blog post by slug
    public function getBlogPostBySlug($slug) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $post = $blogPostModel->getBySlug($slug);
            
            if ($post) {
                // Increment view count
                $blogPostModel->incrementViewCount($post['id']);
                
                $this->sendResponse($post, "Blog post retrieved successfully");
            } else {
                $this->sendError("Blog post not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving blog post: " . $e->getMessage());
        }
    }
    
    // Get blog post by ID
    public function getBlogPostById($id) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $post = $blogPostModel->getById($id);
            
            if ($post) {
                $this->sendResponse($post, "Blog post retrieved successfully");
            } else {
                $this->sendError("Blog post not found", 404);
            }
        } catch (Exception $e) {
            $this->sendError("Error retrieving blog post: " . $e->getMessage());
        }
    }
    
    // Get blog posts by category
    public function getBlogPostsByCategory($category) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getByCategory($category);
            $this->sendResponse($posts, "Blog posts by category retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving blog posts by category: " . $e->getMessage());
        }
    }
    
    // Create new blog post
    public function createBlogPost() {
        try {
            // Get POST data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $required_fields = ['title', 'slug', 'content', 'author_id'];
            foreach ($required_fields as $field) {
                if (!isset($data[$field])) {
                    $this->sendError("Missing required field: $field");
                    return;
                }
            }
            
            $blogPostModel = new BlogPost($this->pdo);
            $result = $blogPostModel->create(
                $data['title'],
                $data['slug'],
                $data['content'],
                $data['excerpt'] ?? null,
                $data['featured_image'] ?? null,
                $data['author_id'],
                $data['category'] ?? null,
                json_encode($data['tags'] ?? []),
                $data['status'] ?? 'draft',
                $data['meta_title'] ?? null,
                $data['meta_description'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Blog post created successfully", 201);
            } else {
                $this->sendError("Failed to create blog post");
            }
        } catch (Exception $e) {
            $this->sendError("Error creating blog post: " . $e->getMessage());
        }
    }
    
    // Update blog post
    public function updateBlogPost($id) {
        try {
            // Get PUT data
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError("Invalid data provided");
                return;
            }
            
            $blogPostModel = new BlogPost($this->pdo);
            $result = $blogPostModel->update(
                $id,
                $data['title'] ?? null,
                $data['slug'] ?? null,
                $data['content'] ?? null,
                $data['excerpt'] ?? null,
                $data['featured_image'] ?? null,
                $data['category'] ?? null,
                json_encode($data['tags'] ?? []),
                $data['status'] ?? null,
                $data['meta_title'] ?? null,
                $data['meta_description'] ?? null
            );
            
            if ($result) {
                $this->sendResponse(null, "Blog post updated successfully");
            } else {
                $this->sendError("Failed to update blog post");
            }
        } catch (Exception $e) {
            $this->sendError("Error updating blog post: " . $e->getMessage());
        }
    }
    
    // Delete blog post
    public function deleteBlogPost($id) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $result = $blogPostModel->delete($id);
            
            if ($result) {
                $this->sendResponse(null, "Blog post deleted successfully");
            } else {
                $this->sendError("Failed to delete blog post");
            }
        } catch (Exception $e) {
            $this->sendError("Error deleting blog post: " . $e->getMessage());
        }
    }
    
    // Search blog posts by keyword
    public function searchBlogPosts($keyword) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->search($keyword);
            $this->sendResponse($posts, "Blog post search results retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error searching blog posts: " . $e->getMessage());
        }
    }
    
    // Get blog posts by tag
    public function getBlogPostsByTag($tag) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getByTag($tag);
            $this->sendResponse($posts, "Blog posts by tag retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving blog posts by tag: " . $e->getMessage());
        }
    }
    
    // Get most viewed blog posts
    public function getMostViewedBlogPosts($limit = 5) {
        try {
            $blogPostModel = new BlogPost($this->pdo);
            $posts = $blogPostModel->getMostViewed($limit);
            $this->sendResponse($posts, "Most viewed blog posts retrieved successfully");
        } catch (Exception $e) {
            $this->sendError("Error retrieving most viewed blog posts: " . $e->getMessage());
        }
    }
}
?>
