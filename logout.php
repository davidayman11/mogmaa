<?php
// Start the session
session_start();

// Debugging: Display current session data
// Uncomment the line below to see session contents for debugging
 var_dump($_SESSION); 

// Check if session variables are set
if (isset($_SESSION['user_id'])) {
    // Unset all session variables
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
}

// Redirect to the login page
header("Location: login.php");
exit();
?>
