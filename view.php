<?php
$serial_number = $_GET['serial_number'];

// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute query
$stmt = $mysqli->prepare("SELECT name, payment, photo FROM attendees WHERE serial_number = ?");
$stmt->bind_param("s", $serial_number);
$stmt->execute();
$stmt->bind_result($name, $payment, $photo);
$stmt->fetch();
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
        h1 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Payment:</strong> <?php echo htmlspecialchars($payment); ?></p>
        <?php if ($photo): ?>
            <p><strong>Photo:</strong></p>
            <img src="<?php echo htmlspecialchars($photo); ?>" alt="Uploaded Photo">
        <?php else: ?>
            <p>No photo uploaded.</p>
        <?php endif; ?>
    </div>
</body>
</html>
