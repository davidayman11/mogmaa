<?php
// Start the session
session_start();

// Check for the message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    // Clear the message after displaying
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="message">
        <?php
        // Display the message if set
        if (isset($message)) {
            echo $message;
        }
        ?>
    </div>
    <!-- Rest of your index page content -->
</body>
</html>
