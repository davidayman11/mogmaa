<?php
session_start();

// Check if the user is already logged in, redirect them to index if true
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
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
    <link rel="stylesheet" href="../css/main.css">
    <meta name="description" content="MOGAM3'24 Admin Login">
    <meta name="keywords" content="MOGAM3, login, admin, authentication">
    <style>
        body {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--gray-100) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: var(--spacing-lg);
        }
    </style>
</head>
<body>
    <div class="login-container fade-in">
        <h2>Admin Login</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="login-form">
            <div class="nice-form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="nice-form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" value="Login" class="btn">
        </form>
    </div>

    <script>
        // Add form enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            const inputs = form.querySelectorAll('input');
            
            // Add focus effects
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Form submission enhancement
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('input[type="submit"]');
                submitBtn.value = 'Logging in...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>

