<?php
session_start(); // Start the session

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Start a new session to store the logout message
session_start();
$_SESSION['logout_msg'] = "You have logged out successfully.";

// Redirect back to the main page or any page you want
header("Location: index.php");
exit();
?>
