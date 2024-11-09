<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in page if the user is not authenticated
    header('location: sign-in');
    exit();
}



?>