<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahaly</title>
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
                    <a href="./login.php">Admin</a>
                </li>
                <li>
                    <a href="./logout.php">Logout</a>
                </li>
                <li>
                    <a href="./ahaly.php">Ahaly</a> <!-- Add this line to navigate to the Ahaly page -->
                </li>
            </ul>
        </nav>
    </div>
    <main class="demo-page-content">
        <section>
            <h1>Welcome to the Ahaly Page</h1>
            <p>This page is dedicated to the Ahaly section.</p>
        </section>
    </main>
</div>
</body>
</html>
