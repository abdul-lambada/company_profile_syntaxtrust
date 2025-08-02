$(document).ready(function() {
    // Handle login form submission
    $('.user').on('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        var email = $('#email').val();
        var password = $('#password').val();
        
        // Validate required fields
        if (!email || !password) {
            alert('Please enter both email and password');
            return;
        }
        
        // Prepare data for API
        var loginData = {
            email: email,
            password: password
        };
        
        // Send AJAX request with JSON data
        $.ajax({
            url: '../../api.php/users/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(loginData),
            success: function(response) {
                // Redirect to dashboard
                window.location.href = '../index.php';
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Login failed';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    });
});
