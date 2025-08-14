<?php
// generate_qrcode.php

// Retrieve parameters
$id = $_GET['id'];
$name = $_GET['name'];
$payment = $_GET['payment'];
$team = $_GET['team'];

// Prepare the data string for the QR code
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);
if (!$qrCodeImageData) {
    die("Failed to generate QR code.");
}

// Define the directory to save the QR code
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

// File name
$qrCodeFileName = $uploadDir . $id . '.png';

// Save the QR code image
file_put_contents($qrCodeFileName, $qrCodeImageData);

// Full URL to the saved QR code
$qrCodeImageUrl = 'http://mogamaaa.shamandorascout.com/' . $qrCodeFileName;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QR Code Preview</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.container {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.container img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}
.button {
    background-color: #0f766e;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
.button:hover {
    background-color: #115e59;
}
</style>
</head>
<body>
<div class="container">
    <h2>QR Code Preview</h2>
    <img src="<?php echo $qrCodeImageUrl; ?>" alt="QR Code">
    <br>
    <a href="<?php echo $qrCodeImageUrl; ?>" download="<?php echo $id; ?>_qrcode.png" class="button">⬇ Download QR Code</a>
</div>
</body>
</html>