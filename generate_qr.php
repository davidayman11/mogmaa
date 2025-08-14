<?php
// generate_qrcode.php
session_start();

// Retrieve parameters
$id = $_GET['id'];
$name = $_GET['name'];
$phone = $_GET['phone'];
$team = $_GET['team'];
$grade = $_GET['grade'];
$payment = $_GET['payment'];

// Prepare the data string for the QR code
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";

// Encode data for QR code URL
$encodedData = urlencode($data);
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);

// Save QR code image
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$qrCodeFileName = $uploadDir . $id . '.png';
if (file_put_contents($qrCodeFileName, $qrCodeImageData)) {
    $qrCodeImageUrl = 'http://mogamaaa.shamandorascout.com/' . $qrCodeFileName;

    // Store session variables
    $_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
    $_SESSION['name'] = $name;
    $_SESSION['phone'] = $phone;
    $_SESSION['serialNumber'] = $id;

    // Redirect to send WhatsApp page
    header("Location: send_whatsapp.php");
    exit();
} else {
    echo "Failed to save QR code image.";
}
?>