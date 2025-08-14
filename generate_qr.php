<?php
// generate_qrcode.php

// Start session
session_start();

// Retrieve parameters
$id = $_GET['id'] ?? '';
$name = $_GET['name'] ?? '';
$phone = $_GET['phone'] ?? '';
$team = $_GET['team'] ?? '';
$grade = $_GET['grade'] ?? '';
$payment = $_GET['payment'] ?? '';

// Prepare the data string for the QR code
$data = "ID: $id\nName: $name\nPayment Amount: $payment\nTeam: $team";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . $encodedData;

// Define the directory to save the QR code image
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Sanitize file name
$qrCodeFileName = $uploadDir . $id . '.png';

// Save QR code image
file_put_contents($qrCodeFileName, file_get_contents($qrCodeUrl));
$qrCodeImageUrl = $qrCodeFileName;

// Save to session
$_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
$_SESSION['name'] = $name;
$_SESSION['phone'] = $phone;
$_SESSION['serialNumber'] = $id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code for <?php echo htmlspecialchars($name); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 22px;
            margin-bottom: 20px;
        }
        img {
            width: 250px;
            height: 250px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background: #4CAF50;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
        }
        .btn:hover {
            background: #45a049;
        }
        .info {
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>QR Code for <?php echo htmlspecialchars($name); ?></h1>
        <div class="info">Payment: <?php echo htmlspecialchars($payment); ?> | Team: <?php echo htmlspecialchars($team); ?></div>
        <img src="<?php echo htmlspecialchars($qrCodeImageUrl); ?>" alt="QR Code">
        <div>
            <a class="btn" href="<?php echo htmlspecialchars($qrCodeImageUrl); ?>" download="QR_<?php echo $id; ?>.png">Download QR Code</a>
            <a class="btn" href="send_whatsapp.php">Send via WhatsApp</a>
        </div>
    </div>
</body>
</html>