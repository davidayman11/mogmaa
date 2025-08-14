<?php
session_start();

if (!isset($_SESSION['name'], $_SESSION['phone'], $_SESSION['serialNumber'], $_SESSION['qrCodeFileName'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];
$qrCodeFileName = $_SESSION['qrCodeFileName'];

// Download link for the QR code (forces download)
$qrDownloadUrl = "http://mogamaaa.shamandorascout.com/download_qr.php?file=" . urlencode($qrCodeFileName);

// WhatsApp message with the download link
$whatsappMessage = "Hello $name,\n\nThank you for registering with Shamandora Scout. Your Serial Number is: $serialNumber. You can download your ticket here: $qrDownloadUrl\n\n" .
                   "مرحباً $name،\n\nشكراً لتسجيلك في Shamandora Scout. رقم التسلسل الخاص بك هو: $serialNumber. يمكنك تحميل تذكرتك من هنا: $qrDownloadUrl";

$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name'], $_SESSION['phone'], $_SESSION['serialNumber'], $_SESSION['qrCodeFileName']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send WhatsApp Message</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.demo-page {
    background-color: #fff;
    padding: 30px 50px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 450px;
}
.demo-page a.button {
    background-color: #0f766e;
    color: #fff;
    padding: 12px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}
.demo-page a.button:hover {
    background-color: #115e59;
}
</style>
</head>
<body>
    <div class="demo-page">
        <h2>Message Ready to Send</h2>
        <p>Your message is ready to be sent via WhatsApp. Click below to proceed.</p>
        <a href="<?php echo $whatsappUrl; ?>" class="button" target="_blank">Send WhatsApp Message</a>
    </div>
</body>
</html>