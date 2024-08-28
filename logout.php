<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Optionally, you can also delete the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}

// Redirect to the login page
header("Location: login.php");
exit();
?>
