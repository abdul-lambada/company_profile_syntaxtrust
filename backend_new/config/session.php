<?php
// Session configuration - must be called before session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS
ini_set('session.cookie_samesite', 'Lax');

// Session name
session_name('SYNTRUST_SESS');

// Start session
session_start();

// Regenerate session ID for security
if (!isset($_SESSION['initialized'])) {
    session_regenerate_id(true);
    $_SESSION['initialized'] = true;
}

// Session timeout (30 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    session_start();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
