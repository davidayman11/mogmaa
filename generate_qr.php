<?php
// auto_download_qr.php

// Retrieve parameters
$id = $_GET['id'] ?? '';
$name = $_GET['name'] ?? '';
$team = $_GET['team'] ?? '';
$payment = $_GET['payment'] ?? '';

if (!$id || !$name) {
    die("Missing required parameters.");
}

// Prepare QR code data
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";
$encodedData = urlencode($data);
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Fetch QR code image
$qrCodeImageData = file_get_contents($qrCodeUrl);
if ($qrCodeImageData === false) {
    die("Failed to generate QR code.");
}

// Sanitize team name for filename
$safeTeam = preg_replace('/[^A-Za-z0-9_\-]/', '_', $team);

// Set headers to force download automatically
header('Content-Description: File Transfer');
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="'.$safeTeam.'_'.$id.'.png"');
header('Content-Length: ' . strlen($qrCodeImageData));
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Output the image
echo $qrCodeImageData;
exit();
?>