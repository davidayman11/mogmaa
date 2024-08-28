<?php
session_start();

// Example login logic
if ($_POST['username'] == 'admin' && $_POST['password'] == 'password') { // Replace with real authentication
    $_SESSION['logged_in'] = true;
    header("Location: index.php"); // Redirect to the main page or dashboard
    exit();
} else {
    echo "Invalid login";
}
?>
