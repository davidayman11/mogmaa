<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Delete the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Set a logout message
    $_SESSION['message'] = "User logged out successfully";
}

// Redirect to the index page
header("Location: index.php");
exit();
?>
