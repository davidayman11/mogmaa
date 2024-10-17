<?php
session_start();

// Dummy credentials for a regular user (for demonstration purposes)
$user_username = 'user';
$user_password = 'userpassword';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify user credentials
    if ($username === $user_username && $password === $user_password) {
        // Set session variables for the user
        $_SESSION['user_loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to index.php after login
        exit();
    } else {
        // Login failed
        echo "<p style='color: red;'>Invalid username or password</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>
        <form action="user_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
