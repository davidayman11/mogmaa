<?php
// generate_qrcode.php

// Start session
session_start();

// Retrieve and sanitize parameters
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_GET, 'phone', FILTER_SANITIZE_STRING);
$team = filter_input(INPUT_GET, 'team', FILTER_SANITIZE_STRING);
$grade = filter_input(INPUT_GET, 'grade', FILTER_SANITIZE_STRING);
$payment = filter_input(INPUT_GET, 'payment', FILTER_SANITIZE_STRING);

// Validate parameters
if (!$id || !$name || !$phone || !$team || !$grade || !$payment) {
    die("Invalid parameters.");
}

// Prepare the data string for the QR code
$data = "Name: $name\nPhone Number: $phone\nTeam: $team\nGrade: $grade\nPayment Amount: $payment";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);

// Define the directory to save the QR code image
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Failed to create directory.");
    }
}

// Sanitize and create the file name using the serial number
$qrCodeFileName = $uploadDir . basename($id) . '.png';

// Save the QR code image to the server
if (file_put_contents($qrCodeFileName, $qrCodeImageData)) {
    // Create the URL to access the QR code image
    $qrCodeImageUrl = 'http://mogamaa.shamandorascout.com/' . $qrCodeFileName;

    // Store the image URL and other data in the session
    $_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
    $_SESSION['name'] = $name;
    $_SESSION['phone'] = $phone;
    $_SESSION['serialNumber'] = $id;

    // Redirect to the page to send the WhatsApp message
    header("Location: send_whatsapp.php");
    exit();
} else {
    echo "Failed to save QR code image.";
}
?>
