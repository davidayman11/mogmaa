<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
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
        .nice-form-group input[type="tel"] {
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
        <?php include 'sidebar.php'; ?>
    <main class="demo-page-content">

        <!-- Display logout message if it exists -->
        <?php if (isset($_SESSION['logout_msg'])): ?>
            <div class="logout-message">
                <?php 
                echo $_SESSION['logout_msg']; 
                unset($_SESSION['logout_msg']); // Remove the message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <section>
            <h1>Enter Details</h1>
            <form action="submit.php" method="post">
                <div class="nice-form-group">
                    <label>Name:</label>
                    <input type="text" name="name" placeholder="Your name" required/>
                </div>
                <div class="nice-form-group">
                    <label>Phone:</label>
                    <input type="tel" name="phone" placeholder="Your Phone" value="+2" required/>
                </div>
                <div class="nice-form-group">
                    <label>Team:</label>
                    <select name="team" required>
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
                    <label>Grade:</label>
                    <input type="text" name="grade" placeholder="Grade" required/>
                </div>
                <div class="nice-form-group">
                    <label>Payment:</label>
                    <input type="text" name="payment" placeholder="Payment" required/>
                </div>
                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
</div>
</body>
</html>
