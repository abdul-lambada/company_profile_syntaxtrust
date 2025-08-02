<?php
// This is the main API entry point that routes requests to appropriate controllers

// Get the request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base path to get the endpoint
$basePath = '/company_profile_syntaxtrust/backend';
$endpoint = str_replace($basePath, '', $uri);

// Route the request based on endpoint and method
switch ($endpoint) {
    // User routes
    case '/users':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        if ($method === 'GET') {
            $controller->getAllUsers();
        } elseif ($method === 'POST') {
            $controller->createUser();
        }
        break;
        
    case '/users/login':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        if ($method === 'POST') {
            $controller->login();
        }
        break;
        
    case '/users/logout':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        if ($method === 'POST') {
            $controller->logout();
        }
        break;
        
    case '/users/verify':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        if ($method === 'POST') {
            $controller->verifyUser();
        }
        break;
        
    case (preg_match('/\/users\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getUserById($id);
        } elseif ($method === 'PUT') {
            $controller->updateUser($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteUser($id);
        }
        break;
        
    // Service routes
    case '/services':
        require_once 'controllers/ServiceController.php';
        $controller = new ServiceController();
        if ($method === 'GET') {
            $controller->getAllServices();
        } elseif ($method === 'POST') {
            $controller->createService();
        }
        break;
        
    case '/services/featured':
        require_once 'controllers/ServiceController.php';
        $controller = new ServiceController();
        if ($method === 'GET') {
            $controller->getFeaturedServices();
        }
        break;
        
    case (preg_match('/\/services\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ServiceController.php';
        $controller = new ServiceController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getServiceById($id);
        } elseif ($method === 'PUT') {
            $controller->updateService($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteService($id);
        }
        break;
        
    case (preg_match('/\/services\/search\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ServiceController.php';
        $controller = new ServiceController();
        $keyword = $matches[1];
        if ($method === 'GET') {
            $controller->searchServices($keyword);
        }
        break;
        
    // Pricing Plan routes
    case '/pricing-plans':
        require_once 'controllers/PricingPlanController.php';
        $controller = new PricingPlanController();
        if ($method === 'GET') {
            $controller->getAllPricingPlans();
        } elseif ($method === 'POST') {
            $controller->createPricingPlan();
        }
        break;
        
    case '/pricing-plans/popular':
        require_once 'controllers/PricingPlanController.php';
        $controller = new PricingPlanController();
        if ($method === 'GET') {
            $controller->getPopularPricingPlans();
        }
        break;
        
    case (preg_match('/\/pricing-plans\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/PricingPlanController.php';
        $controller = new PricingPlanController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getPricingPlanById($id);
        } elseif ($method === 'PUT') {
            $controller->updatePricingPlan($id);
        } elseif ($method === 'DELETE') {
            $controller->deletePricingPlan($id);
        }
        break;
        
    // Portfolio routes
    case '/portfolio':
        require_once 'controllers/PortfolioController.php';
        $controller = new PortfolioController();
        if ($method === 'GET') {
            $controller->getAllPortfolioItems();
        } elseif ($method === 'POST') {
            $controller->createPortfolioItem();
        }
        break;
        
    case '/portfolio/featured':
        require_once 'controllers/PortfolioController.php';
        $controller = new PortfolioController();
        if ($method === 'GET') {
            $controller->getFeaturedPortfolioItems();
        }
        break;
        
    case (preg_match('/\/portfolio\/category\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/PortfolioController.php';
        $controller = new PortfolioController();
        $category = $matches[1];
        if ($method === 'GET') {
            $controller->getPortfolioByCategory($category);
        }
        break;
        
    case (preg_match('/\/portfolio\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/PortfolioController.php';
        $controller = new PortfolioController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getPortfolioItemById($id);
        } elseif ($method === 'PUT') {
            $controller->updatePortfolioItem($id);
        } elseif ($method === 'DELETE') {
            $controller->deletePortfolioItem($id);
        }
        break;
        
    case (preg_match('/\/portfolio\/search\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/PortfolioController.php';
        $controller = new PortfolioController();
        $keyword = $matches[1];
        if ($method === 'GET') {
            $controller->searchPortfolioItems($keyword);
        }
        break;
        
    // Team routes
    case '/team':
        require_once 'controllers/TeamController.php';
        $controller = new TeamController();
        if ($method === 'GET') {
            $controller->getAllTeamMembers();
        } elseif ($method === 'POST') {
            $controller->createTeamMember();
        }
        break;
        
    case (preg_match('/\/team\/skill\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/TeamController.php';
        $controller = new TeamController();
        $skill = $matches[1];
        if ($method === 'GET') {
            $controller->searchTeamBySkill($skill);
        }
        break;
        
    case (preg_match('/\/team\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/TeamController.php';
        $controller = new TeamController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getTeamMemberById($id);
        } elseif ($method === 'PUT') {
            $controller->updateTeamMember($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteTeamMember($id);
        }
        break;
        
    // Client routes
    case '/clients':
        require_once 'controllers/ClientController.php';
        $controller = new ClientController();
        if ($method === 'GET') {
            $controller->getAllClients();
        } elseif ($method === 'POST') {
            $controller->createClient();
        }
        break;
        
    case (preg_match('/\/clients\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ClientController.php';
        $controller = new ClientController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getClientById($id);
        } elseif ($method === 'PUT') {
            $controller->updateClient($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteClient($id);
        }
        break;
        
    // Contact Inquiry routes
    case '/contact-inquiries':
        require_once 'controllers/ContactInquiryController.php';
        $controller = new ContactInquiryController();
        if ($method === 'GET') {
            $controller->getAllContactInquiries();
        } elseif ($method === 'POST') {
            $controller->createContactInquiry();
        }
        break;
        
    case (preg_match('/\/contact-inquiries\/status\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ContactInquiryController.php';
        $controller = new ContactInquiryController();
        $status = $matches[1];
        if ($method === 'GET') {
            $controller->getContactInquiriesByStatus($status);
        }
        break;
        
    case (preg_match('/\/contact-inquiries\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ContactInquiryController.php';
        $controller = new ContactInquiryController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getContactInquiryById($id);
        } elseif ($method === 'PUT') {
            // Check if this is a status update
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['status'])) {
                $controller->updateContactInquiryStatus($id);
            } else {
                $controller->updateContactInquiry($id);
            }
        } elseif ($method === 'DELETE') {
            $controller->deleteContactInquiry($id);
        }
        break;
        
    case (preg_match('/\/contact-inquiries\/service\/(\d+)\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ContactInquiryController.php';
        $controller = new ContactInquiryController();
        $service_id = $matches[1];
        $service_name = $matches[2];
        if ($method === 'GET') {
            $controller->getContactInquiriesByService($service_id, $service_name);
        }
        break;
        
    case (preg_match('/\/contact-inquiries\/(\d+)\/replied/', $endpoint, $matches) ? true : false):
        require_once 'controllers/ContactInquiryController.php';
        $controller = new ContactInquiryController();
        $id = $matches[1];
        if ($method === 'PUT') {
            $controller->markAsReplied($id);
        }
        break;
        
    // Order routes
    case '/orders':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        if ($method === 'GET') {
            $controller->getAllOrders();
        } elseif ($method === 'POST') {
            $controller->createOrder();
        }
        break;
        
    case '/orders/requirements':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        if ($method === 'POST') {
            $controller->createOrderWithRequirements();
        }
        break;
        
    case (preg_match('/\/orders\/number\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $order_number = $matches[1];
        if ($method === 'GET') {
            $controller->getOrderByOrderNumber($order_number);
        }
        break;
        
    case (preg_match('/\/orders\/status\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $status = $matches[1];
        if ($method === 'GET') {
            $controller->getOrdersByStatus($status);
        }
        break;
        
    case (preg_match('/\/orders\/payment-status\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $payment_status = $matches[1];
        if ($method === 'GET') {
            $controller->getOrdersByPaymentStatus($payment_status);
        }
        break;
        
    case (preg_match('/\/orders\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getOrderById($id);
        } elseif ($method === 'PUT') {
            // Check if this is a status update or payment status update
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['status'])) {
                $controller->updateOrderStatus($id);
            } elseif (isset($data['payment_status'])) {
                $controller->updatePaymentStatus($id);
            } else {
                $controller->updateOrder($id);
            }
        } elseif ($method === 'DELETE') {
            $controller->deleteOrder($id);
        }
        break;
        
    case (preg_match('/\/orders\/(\d+)\/details/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getOrderDetails($id);
        }
        break;
        
    case (preg_match('/\/orders\/(\d+)\/requirements/', $endpoint, $matches) ? true : false):
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $id = $matches[1];
        if ($method === 'PUT') {
            $controller->updateOrderRequirements($id);
        }
        break;
        
    // Blog Post routes
    case '/blog-posts':
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        if ($method === 'GET') {
            $controller->getAllBlogPosts();
        } elseif ($method === 'POST') {
            $controller->createBlogPost();
        }
        break;
        
    case '/blog-posts/published':
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        if ($method === 'GET') {
            $controller->getPublishedBlogPosts();
        }
        break;
        
    case '/blog-posts/featured':
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        if ($method === 'GET') {
            $controller->getFeaturedBlogPosts();
        }
        break;
        
    case '/blog-posts/most-viewed':
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        if ($method === 'GET') {
            $controller->getMostViewedBlogPosts();
        }
        break;
        
    case (preg_match('/\/blog-posts\/slug\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        $slug = $matches[1];
        if ($method === 'GET') {
            $controller->getBlogPostBySlug($slug);
        }
        break;
        
    case (preg_match('/\/blog-posts\/category\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        $category = $matches[1];
        if ($method === 'GET') {
            $controller->getBlogPostsByCategory($category);
        }
        break;
        
    case (preg_match('/\/blog-posts\/tag\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        $tag = $matches[1];
        if ($method === 'GET') {
            $controller->getBlogPostsByTag($tag);
        }
        break;
        
    case (preg_match('/\/blog-posts\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getBlogPostById($id);
        } elseif ($method === 'PUT') {
            $controller->updateBlogPost($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteBlogPost($id);
        }
        break;
        
    case (preg_match('/\/blog-posts\/search\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/BlogPostController.php';
        $controller = new BlogPostController();
        $keyword = $matches[1];
        if ($method === 'GET') {
            $controller->searchBlogPosts($keyword);
        }
        break;
        
    // Testimonial routes
    case '/testimonials':
        require_once 'controllers/TestimonialController.php';
        $controller = new TestimonialController();
        if ($method === 'GET') {
            $controller->getAllTestimonials();
        } elseif ($method === 'POST') {
            $controller->createTestimonial();
        }
        break;
        
    case '/testimonials/featured':
        require_once 'controllers/TestimonialController.php';
        $controller = new TestimonialController();
        if ($method === 'GET') {
            $controller->getFeaturedTestimonials();
        }
        break;
        
    case (preg_match('/\/testimonials\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/TestimonialController.php';
        $controller = new TestimonialController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getTestimonialById($id);
        } elseif ($method === 'PUT') {
            $controller->updateTestimonial($id);
        } elseif ($method === 'DELETE') {
            $controller->deleteTestimonial($id);
        }
        break;
        
    // Setting routes
    case '/settings':
        require_once 'controllers/SettingController.php';
        $controller = new SettingController();
        if ($method === 'GET') {
            $controller->getAllSettings();
        } elseif ($method === 'POST') {
            $controller->createSetting();
        }
        break;
        
    case '/settings/multiple':
        require_once 'controllers/SettingController.php';
        $controller = new SettingController();
        if ($method === 'POST') {
            $controller->getSettingsByKeys();
        } elseif ($method === 'PUT') {
            $controller->updateMultipleSettings();
        }
        break;
        
    case (preg_match('/\/settings\/(.+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/SettingController.php';
        $controller = new SettingController();
        $key = $matches[1];
        if ($method === 'GET') {
            $controller->getSettingByKey($key);
        } elseif ($method === 'PUT') {
            $controller->updateSetting($key);
        } elseif ($method === 'DELETE') {
            $controller->deleteSetting($key);
        }
        break;
        
    // Notification routes
    case '/notifications':
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        if ($method === 'GET') {
            $controller->getAllNotifications();
        } elseif ($method === 'POST') {
            $controller->createNotification();
        }
        break;
        
    case (preg_match('/\/notifications\/user\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        $user_id = $matches[1];
        if ($method === 'GET') {
            $controller->getNotificationsByUserId($user_id);
        }
        break;
        
    case (preg_match('/\/notifications\/user\/(\d+)\/unread/', $endpoint, $matches) ? true : false):
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        $user_id = $matches[1];
        if ($method === 'GET') {
            $controller->getUnreadNotificationsByUserId($user_id);
        }
        break;
        
    case (preg_match('/\/notifications\/(\d+)/', $endpoint, $matches) ? true : false):
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        $id = $matches[1];
        if ($method === 'GET') {
            $controller->getNotificationById($id);
        } elseif ($method === 'PUT') {
            // Check if this is a mark as read request
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['is_read']) && $data['is_read'] === true) {
                $controller->markAsRead($id);
            } else {
                $controller->updateNotification($id);
            }
        } elseif ($method === 'DELETE') {
            $controller->deleteNotification($id);
        }
        break;
        
    case (preg_match('/\/notifications\/user\/(\d+)\/read-all/', $endpoint, $matches) ? true : false):
        require_once 'controllers/NotificationController.php';
        $controller = new NotificationController();
        $user_id = $matches[1];
        if ($method === 'PUT') {
            $controller->markAllAsRead($user_id);
        }
        break;
        
    default:
        // Return 404 for unmatched routes
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?>
