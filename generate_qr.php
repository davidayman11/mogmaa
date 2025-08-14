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
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);

// Define the directory to save the QR code image
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Create the file path
$qrCodeFileName = $id . '.png';
$qrCodeFilePath = $uploadDir . $qrCodeFileName;

// Save QR code image
if (file_put_contents($qrCodeFilePath, $qrCodeImageData)) {
    session_start();
    $_SESSION['qrCodeFileName'] = $qrCodeFileName;
    $_SESSION['name'] = $name;
    $_SESSION['phone'] = $phone;
    $_SESSION['serialNumber'] = $id;

    // Redirect to send WhatsApp
    header("Location: send_whatsapp.php");
    exit();
} else {
    echo "Failed to save QR code image.";
}