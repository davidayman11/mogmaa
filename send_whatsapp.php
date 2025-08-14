<?php
session_start();

// Check session data
if (!isset($_SESSION['qrCodeImageUrl'], $_SESSION['name'], $_SESSION['id'])) {
    die("No QR code data available.");
}

$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];
$name = $_SESSION['name'];
$id = $_SESSION['id'];

// WhatsApp message
$phone = $phone ; // User phone (international format)
$message = "Hello $name,\nHere is your QR code: $qrCodeImageUrl";
$whatsappUrl = "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);

// Clear session
unset($_SESSION['qrCodeImageUrl'], $_SESSION['name'], $_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send WhatsApp Message</title>
<style>
body { font-family: 'Segoe UI', sans-serif; background:#f4f4f4; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
.container { background:#fff; padding:30px; border-radius:12px; text-align:center; box-shadow:0 8px 25px rgba(0,0,0,0.1); }
.container img { max-width:100%; height:auto; margin-bottom:20px; }
.button { background:#0f766e; color:#fff; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:bold; }
.button:hover { background:#115e59; }
</style>
</head>
<body>
<div class="container">
    <h2>QR Code Preview</h2>
    <img src="<?php echo $qrCodeImageUrl; ?>" alt="QR Code">
    <br><br>
    <a href="<?php echo $qrCodeImageUrl; ?>" download="<?php echo $id; ?>_qrcode.png" class="button">⬇ Download QR Code</a>
    <br><br>
    <a href="<?php echo $whatsappUrl; ?>" target="_blank" class="button">Send via WhatsApp</a>
</div>
</body>
</html>