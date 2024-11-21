<?php
session_start();

// Check if the user is already logged in, redirect them to index if true
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded username and password (you can change this to fetch from a database)
    $valid_username = 'admin';
    $valid_password = 'password'; // Note: Use secure methods for production

    if ($username == $valid_username && $password == $valid_password) {
        // Set session to mark user as logged in
        $_SESSION['user_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MOGAM3'24</title>
    <style>
        /* Your login form styles */
    </style>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error_message)): ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
