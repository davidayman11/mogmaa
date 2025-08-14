<?php
session_start();

// Retrieve parameters
$id = $_GET['id'] ?? '';
$name = $_GET['name'] ?? '';
$phone = $_GET['phone'] ?? '';
$team = $_GET['team'] ?? '';
$payment = $_GET['payment'] ?? '';

if (!$id || !$name || !$phone) {
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

// Save temporary file
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
$safeTeam = preg_replace('/[^A-Za-z0-9_\-]/', '_', $team);
$qrFile = $uploadDir . $safeTeam . '_' . $id . '.png';
file_put_contents($qrFile, $qrCodeImageData);

// Store in session for WhatsApp page
$_SESSION['name'] = $name;
$_SESSION['phone'] = $phone;
$_SESSION['serialNumber'] = $id;
$_SESSION['qrCodeImageUrl'] = 'http://mogamaaa.shamandorascout.com/' . $qrFile;

// Auto-download QR
header('Content-Description: File Transfer');
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="'.$safeTeam.'_'.$id.'.png"');
header('Content-Length: ' . strlen($qrCodeImageData));
header('Cache-Control: must-revalidate');
header('Pragma: public');

echo $qrCodeImageData;
exit();
?>