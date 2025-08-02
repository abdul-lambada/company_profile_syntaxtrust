<?php
class BlogPost {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Create Blog Post
    public function create($title, $slug, $content, $excerpt, $featured_image, $author_id, $category, $tags, $status, $meta_title, $meta_description) {
        $sql = "INSERT INTO blog_posts (title, slug, content, excerpt, featured_image, author_id, category, tags, status, meta_title, meta_description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $author_id, $category, $tags, $status, $meta_title, $meta_description]);
    }
    
    // Read All Published Blog Posts
    public function getPublished() {
        $sql = "SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read All Blog Posts (admin)
    public function getAll() {
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Featured Blog Posts
    public function getFeatured() {
        $sql = "SELECT * FROM blog_posts WHERE status = 'published' AND is_featured = TRUE ORDER BY published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Read Blog Post by Slug
    public function getBySlug($slug) {
        $sql = "SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read Blog Post by ID
    public function getById($id) {
        $sql = "SELECT * FROM blog_posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Read Blog Posts by Category
    public function getByCategory($category) {
        $sql = "SELECT * FROM blog_posts WHERE category = ? AND status = 'published' ORDER BY published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update Blog Post
    public function update($id, $title, $slug, $content, $excerpt, $featured_image, $category, $tags, $status, $meta_title, $meta_description) {
        $sql = "UPDATE blog_posts 
                SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, category = ?, tags = ?, status = ?, meta_title = ?, meta_description = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $category, $tags, $status, $meta_title, $meta_description, $id]);
    }
    
    // Delete Blog Post
    public function delete($id) {
        $sql = "DELETE FROM blog_posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Search blog posts by keyword
    public function search($keyword) {
        $sql = "SELECT * FROM blog_posts 
                WHERE status = 'published'
                AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ? OR category LIKE ?)
                ORDER BY published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get blog posts by tag
    public function getByTag($tag) {
        $sql = "SELECT * FROM blog_posts 
                WHERE status = 'published'
                AND JSON_CONTAINS(tags, ?)
                ORDER BY published_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tag]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Increment blog post view count
    public function incrementViewCount($id) {
        $sql = "UPDATE blog_posts 
                SET view_count = view_count + 1 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get most viewed blog posts
    public function getMostViewed($limit = 5) {
        $sql = "SELECT * FROM blog_posts 
                WHERE status = 'published'
                ORDER BY view_count DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
