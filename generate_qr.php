<?php
session_start();

// Validate required GET parameters
$requiredFields = ['id', 'name', 'phone', 'team', 'grade', 'payment'];
foreach ($requiredFields as $field) {
    if (empty($_GET[$field])) {
        die("Missing required parameter: " . htmlspecialchars($field));
    }
}

// Sanitize input
$id      = intval($_GET['id']);
$name    = trim($_GET['name']);
$phone   = trim($_GET['phone']);
$team    = trim($_GET['team']);
$grade   = trim($_GET['grade']);
$payment = trim($_GET['payment']);

// Prepare QR data (only include what’s needed)
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";
$encodedData = urlencode($data);

// Generate QR code
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data={$encodedData}";
$qrCodeImageData = @file_get_contents($qrCodeUrl);

if ($qrCodeImageData === false) {
    die("Failed to generate QR code from API.");
}

// Create directory for storing QR codes if it doesn’t exist
$uploadDir = __DIR__ . '/qrcodes/';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    die("Failed to create QR code directory.");
}

// Save QR code image locally
$qrCodeFileName = $uploadDir . $id . '.png';
if (file_put_contents($qrCodeFileName, $qrCodeImageData) === false) {
    die("Failed to save QR code image.");
}

// Build accessible URL (relative to your domain)
$qrCodeImageUrl = "https://mogamaaa.shamandorascout.com/qrcodes/{$id}.png";

// Store in session for later use
$_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
$_SESSION['name']           = $name;
$_SESSION['phone']          = $phone;
$_SESSION['serialNumber']   = $id;

// Redirect to WhatsApp sending page
header("Location: send_whatsapp.php");
exit;