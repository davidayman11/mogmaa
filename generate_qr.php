<?php
// generate_qrcode.php

// Retrieve parameters
$id = $_GET['id'];
$name = $_GET['name'];
$payment = $_GET['payment'];
$team = $_GET['team'];

// Prepare QR code data
$data = "Name: $name\nPayment Amount: $payment\nTeam: $team";
$encodedData = urlencode($data);

// Generate QR code from API
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;
$qrCodeImageData = file_get_contents($qrCodeUrl);
if (!$qrCodeImageData) die("Failed to generate QR code.");

// Directory and file name
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
$qrCodeFileName = $uploadDir . $id . '.png';
file_put_contents($qrCodeFileName, $qrCodeImageData);

// Full URL for preview/download
$qrCodeImageUrl = 'http://mogamaaa.shamandorascout.com/' . $qrCodeFileName;

// Save in session for WhatsApp
session_start();
$_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
$_SESSION['name'] = $name;
$_SESSION['payment'] = $payment;
$_SESSION['team'] = $team;
$_SESSION['id'] = $id;

// Redirect to WhatsApp send page
header("Location: send_whatsapp.php");
exit;