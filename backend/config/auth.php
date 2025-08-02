<?php
// Authentication functions

session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Get current user data
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'user_type' => $_SESSION['user_type']
        ];
    }
    return null;
}

// Redirect to login page if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../views/pages/login.php');
        exit();
    }
}

// Log in user
function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_type'] = $user['user_type'];
}

// Log out user
function logoutUser() {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['user_type']);
    session_destroy();
}
?>
