<?php
session_start(); // Start the session

// Check if user is logged in
$loggedIn = isset($_SESSION['user']); // This can be enhanced with proper login check
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .demo-page {
            display: flex;
            height: 100vh;
        }

        .demo-page-navigation {
            width: 250px;
            background-color: #333;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .demo-page-navigation nav ul {
            list-style: none;
            padding: 0;
        }

        .demo-page-navigation nav ul li {
            margin-bottom: 20px;
        }

        .demo-page-navigation nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .demo-page-navigation nav ul li a svg {
            margin-right: 10px;
        }

        .demo-page-content {
            flex-grow: 1;
            padding: 40px;
        }

        .demo-page-content h1 {
            margin-top: 0;
            color: #4CAF50;
        }

        .nice-form-group {
            margin-bottom: 15px;
        }

        .nice-form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .nice-form-group input[type="text"],
        .nice-form-group input[type="tel"],
        .nice-form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .logout-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <nav>
            <ul>
                <li>
                    <a href="./index.php">MOGAM3'24</a>
                </li>
                <li>
                    <a href="./show.php">Details</a>
                </li>
                <li>
                    <a href="./ahaly.php">Ahaly</a>
                </li>
                <li>
                    <a href="./login.php">Admin</a>
                </li>
                <li>
                    <a href="./logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
    <main class="demo-page-content">
        <!-- Check if user is logged in -->
        <?php if (!$loggedIn): ?>
            <section>
                <h1>Login</h1>
                <form action="login_handler.php" method="post">
                    <div class="nice-form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" placeholder="Enter username" required>
                    </div>
                    <div class="nice-form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" placeholder="Enter password" required>
                    </div>
                    <input type="submit" value="Login">
                </form>
            </section>
        <?php else: ?>
            <!-- If logged in, show the details form -->
            <section>
                <h1>Enter Details</h1>
                <form action="submit.php" method="post">
                    <div class="nice-form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" placeholder="Your name" required>
                    </div>
                    <div class="nice-form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" name="phone" id="phone" placeholder="Your phone" value="+2" required pattern="\+2[0-9]{10}">
                    </div>
                    <div class="nice-form-group">
                        <label for="team">Team:</label>
                        <select name="team" id="team" required>
                            <option value="" disabled selected>Select your team</option>
                            <option value="bra3em">bra3em</option>
                            <option value="ashbal">ashbal</option>
                            <option value="zahrat">zahrat</option>
                            <option value="kshafa">kshafa</option>
                            <option value="morshdat">morshdat</option>
                            <option value="motkadem">motkadem</option>
                            <option value="ra2edat">ra2edat</option>
                            <option value="gwala">gwala</option>
                            <option value="kada">kada</option>
                        </select>
                    </div>
                    <div class="nice-form-group">
                        <label for="grade">Grade:</label>
                        <input type="text" name="grade" id="grade" placeholder="Grade" required>
                    </div>
                    <div class="nice-form-group">
                        <label for="payment">Payment:</label>
                        <input type="text" name="payment" id="payment" placeholder="Payment" required>
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </section>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
