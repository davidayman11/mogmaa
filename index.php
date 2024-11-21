<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MOGAM3'24</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-page">
    <div class="login-form">
        <h2>Login</h2>

        <!-- Display error message if login failed -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error-message">
                <?php 
                echo $_SESSION['login_error']; 
                unset($_SESSION['login_error']); // Remove the error message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <form action="login_process.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" class="login-btn" value="Login">
        </form>
    </div>
</div>

</body>
</html>
