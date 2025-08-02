# SyntaxTrust Backend API

This is the PHP backend API for the SyntaxTrust company profile website. It provides CRUD operations for all entities and follows RESTful principles.

## Directory Structure

```
backend/
├── config/
│   └── database.php          # Database configuration and connection
├── controllers/
│   ├── BaseController.php    # Base controller with common functionality
│   ├── UserController.php    # User management and authentication
│   ├── ServiceController.php # Service management
│   ├── PricingPlanController.php # Pricing plan management
│   ├── PortfolioController.php   # Portfolio management
│   ├── TeamController.php    # Team member management
│   ├── ClientController.php  # Client management
│   ├── ContactInquiryController.php # Contact form inquiries
│   ├── OrderController.php   # Order management
│   ├── BlogPostController.php # Blog post management
│   ├── TestimonialController.php  # Testimonial management
│   ├── SettingController.php # Site settings management
│   └── NotificationController.php # User notifications
├── models/
│   ├── User.php             # User database operations
│   ├── Service.php         # Service database operations
│   ├── PricingPlan.php     # Pricing plan database operations
│   ├── Portfolio.php       # Portfolio database operations
│   ├── Team.php            # Team member database operations
│   ├── Client.php          # Client database operations
│   ├── ContactInquiry.php  # Contact inquiry database operations
│   ├── Order.php           # Order database operations
│   ├── BlogPost.php        # Blog post database operations
│   ├── Testimonial.php     # Testimonial database operations
│   ├── Setting.php         # Setting database operations
│   └── Notification.php   # Notification database operations
├── api.php                 # Main API entry point
└── .htaccess               # URL rewriting rules
```

## API Endpoints

### Users
- `GET /users` - Get all users
- `POST /users` - Create a new user
- `GET /users/{id}` - Get user by ID
- `PUT /users/{id}` - Update user by ID
- `DELETE /users/{id}` - Delete user by ID (soft delete)
- `POST /users/login` - User login
- `POST /users/verify` - Verify user credentials

### Services
- `GET /services` - Get all services
- `POST /services` - Create a new service
- `GET /services/featured` - Get featured services
- `GET /services/{id}` - Get service by ID
- `PUT /services/{id}` - Update service by ID
- `DELETE /services/{id}` - Delete service by ID (soft delete)
- `GET /services/search/{keyword}` - Search services by keyword

### Pricing Plans
- `GET /pricing-plans` - Get all pricing plans
- `POST /pricing-plans` - Create a new pricing plan
- `GET /pricing-plans/popular` - Get popular pricing plans
- `GET /pricing-plans/{id}` - Get pricing plan by ID
- `PUT /pricing-plans/{id}` - Update pricing plan by ID
- `DELETE /pricing-plans/{id}` - Delete pricing plan by ID (soft delete)

### Portfolio
- `GET /portfolio` - Get all portfolio items
- `POST /portfolio` - Create a new portfolio item
- `GET /portfolio/featured` - Get featured portfolio items
- `GET /portfolio/category/{category}` - Get portfolio items by category
- `GET /portfolio/{id}` - Get portfolio item by ID
- `PUT /portfolio/{id}` - Update portfolio item by ID
- `DELETE /portfolio/{id}` - Delete portfolio item by ID (soft delete)
- `GET /portfolio/search/{keyword}` - Search portfolio items by keyword

### Team
- `GET /team` - Get all team members
- `POST /team` - Create a new team member
- `GET /team/{id}` - Get team member by ID
- `PUT /team/{id}` - Update team member by ID
- `DELETE /team/{id}` - Delete team member by ID (soft delete)
- `GET /team/skill/{skill}` - Search team members by skill

### Clients
- `GET /clients` - Get all clients
- `POST /clients` - Create a new client
- `GET /clients/{id}` - Get client by ID
- `PUT /clients/{id}` - Update client by ID
- `DELETE /clients/{id}` - Delete client by ID (soft delete)

### Contact Inquiries
- `GET /contact-inquiries` - Get all contact inquiries
- `POST /contact-inquiries` - Create a new contact inquiry
- `GET /contact-inquiries/{id}` - Get contact inquiry by ID
- `GET /contact-inquiries/status/{status}` - Get contact inquiries by status
- `PUT /contact-inquiries/{id}` - Update contact inquiry by ID
- `PUT /contact-inquiries/{id}/replied` - Mark contact inquiry as replied
- `DELETE /contact-inquiries/{id}` - Delete contact inquiry by ID
- `GET /contact-inquiries/service/{service_id}/{service_name}` - Get inquiries by service

### Orders
- `GET /orders` - Get all orders
- `POST /orders` - Create a new order
- `POST /orders/requirements` - Create a new order with requirements
- `GET /orders/{id}` - Get order by ID
- `GET /orders/number/{order_number}` - Get order by order number
- `GET /orders/status/{status}` - Get orders by status
- `GET /orders/payment-status/{payment_status}` - Get orders by payment status
- `PUT /orders/{id}` - Update order by ID
- `PUT /orders/{id}/status` - Update order status
- `PUT /orders/{id}/payment-status` - Update order payment status
- `PUT /orders/{id}/requirements` - Update order requirements
- `DELETE /orders/{id}` - Delete order by ID
- `GET /orders/{id}/details` - Get detailed order information

### Blog Posts
- `GET /blog-posts` - Get all blog posts (admin)
- `GET /blog-posts/published` - Get all published blog posts
- `POST /blog-posts` - Create a new blog post
- `GET /blog-posts/featured` - Get featured blog posts
- `GET /blog-posts/most-viewed` - Get most viewed blog posts
- `GET /blog-posts/{id}` - Get blog post by ID
- `GET /blog-posts/slug/{slug}` - Get blog post by slug
- `GET /blog-posts/category/{category}` - Get blog posts by category
- `GET /blog-posts/tag/{tag}` - Get blog posts by tag
- `GET /blog-posts/search/{keyword}` - Search blog posts by keyword
- `PUT /blog-posts/{id}` - Update blog post by ID
- `DELETE /blog-posts/{id}` - Delete blog post by ID (soft delete)

### Testimonials
- `GET /testimonials` - Get all testimonials
- `POST /testimonials` - Create a new testimonial
- `GET /testimonials/featured` - Get featured testimonials
- `GET /testimonials/{id}` - Get testimonial by ID
- `PUT /testimonials/{id}` - Update testimonial by ID
- `DELETE /testimonials/{id}` - Delete testimonial by ID (soft delete)

### Settings
- `GET /settings` - Get all settings
- `POST /settings` - Create a new setting
- `POST /settings/multiple` - Get multiple settings by keys
- `PUT /settings/multiple` - Update multiple settings
- `GET /settings/{key}` - Get setting by key
- `PUT /settings/{key}` - Update setting by key
- `DELETE /settings/{key}` - Delete setting by key

### Notifications
- `GET /notifications` - Get all notifications
- `POST /notifications` - Create a new notification
- `GET /notifications/{id}` - Get notification by ID
- `GET /notifications/user/{user_id}` - Get notifications by user ID
- `GET /notifications/user/{user_id}/unread` - Get unread notifications by user ID
- `PUT /notifications/user/{user_id}/read-all` - Mark all notifications as read for user
- `PUT /notifications/{id}` - Update notification by ID
- `DELETE /notifications/{id}` - Delete notification by ID (soft delete)

## Database Schema

The database schema is defined in `mysql_crud_queries.sql` in the root directory. It includes tables for:
- Users
- Services
- Pricing Plans
- Portfolio
- Team Members
- Clients
- Contact Inquiries
- Orders
- Blog Posts
- Testimonials
- Settings
- Notifications

## Authentication

The API uses bcrypt for password hashing and verification. Login endpoints return authentication tokens that should be used for subsequent requests requiring authentication.

## JSON Handling

JSON fields in the database are handled as JSON strings in PHP models and controllers. They are properly encoded/decoded when stored and retrieved.

## Error Handling

All controllers return JSON responses with appropriate HTTP status codes:
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 404: Not Found
- 500: Internal Server Error

## Usage

1. Ensure you have a MySQL database set up with the schema from `mysql_crud_queries.sql`
2. Update the database configuration in `config/database.php`
3. Make sure URL rewriting is enabled on your server
4. Send HTTP requests to the appropriate endpoints as documented above

## Security Considerations

- All database queries use prepared statements to prevent SQL injection
- Passwords are hashed using bcrypt
- Soft deletes are implemented for most entities
- Input validation is performed in controllers
