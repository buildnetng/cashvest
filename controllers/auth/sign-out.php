<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// If a session cookie exists, delete it by setting its expiration time to the past
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location:home");
exit;
