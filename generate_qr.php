<?php
// generate_qrcode.php

// Retrieve parameters
$id = $_GET['id'];
$name = $_GET['name'];
$phone = $_GET['phone'];
$team = $_GET['team'];
$grade = $_GET['grade'];
$payment = $_GET['payment'];

// Prepare the data string for the QR code
$data = "Name: $name\nPhone Number: $phone\nTeam: $team\nGrade: $grade\nPayment Amount: $payment";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);

// Check if QR code data was successfully retrieved
if (!$qrCodeImageData) {
    die("Failed to retrieve QR code from URL: $qrCodeUrl");
}

// Define the directory to save the QR code image
$uploadDir = __DIR__ . '/qrcodes/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
}

// Sanitize and create the file name using the serial number
$qrCodeFileName = $uploadDir . $id . '.png';

// Save the QR code image to the server
if (file_put_contents($qrCodeFileName, $qrCodeImageData)) {
    // Create the URL to access the QR code image
    $qrCodeImageUrl = 'http://193.203.168.53/qrcodes/' . $id . '.png';

    // Store the image URL in the session for later use
    session_start();
    $_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
    $_SESSION['name'] = $name;
    $_SESSION['phone'] = $phone;
    $_SESSION['serialNumber'] = $id;

    // Redirect to the page to send the WhatsApp message
    header("Location: send_whatsapp.php");
    exit();
} else {
    die("Failed to save QR code image.");
}
?>
