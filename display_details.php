<?php
// display_details.php

// Retrieve parameters from the URL
$id = $_GET['id'];
$name = $_GET['name'];
$phone = $_GET['phone'];
$team = $_GET['team'];
$grade = $_GET['grade'];
$payment = $_GET['payment'];
$photoUrl = $_GET['photo']; // Photo URL

// HTML and CSS for displaying the details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .photo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Details</h1>
        <img src="<?php echo htmlspecialchars($photoUrl); ?>" alt="Employee Photo" class="photo">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Serial Number:</strong> <?php echo htmlspecialchars($id); ?></p>
        <p><strong>Payment Amount:</strong> <?php echo htmlspecialchars($payment); ?></p>
    </div>
</body>
</html>
