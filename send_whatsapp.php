<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['phone']) || !isset($_SESSION['serialNumber']) || !isset($_SESSION['qrCodeImageUrl'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];
$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];

// Prepare WhatsApp message
$whatsappMessage = "Hello $name,\n\nThank you for registering with Shamandora Scout. Your Serial Number is: $serialNumber. You can access your ticket here: $qrCodeImageUrl. Please save this number to view your ticket.\n\n" .
                   "مرحباً $name،\n\nشكراً لتسجيلك في Shamandora Scout. رقم التسلسل الخاص بك هو: $serialNumber. يمكنك الوصول إلى تذكرتك هنا: $qrCodeImageUrl.";

$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name'], $_SESSION['phone'], $_SESSION['serialNumber'], $_SESSION['qrCodeImageUrl']);
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
    margin: 0;
    padding: 0;
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
    width: 100%;
    transition: transform 0.2s, box-shadow 0.2s;
}
.demo-page:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.demo-page h2 {
    color: #0f766e;
    margin-bottom: 20px;
    font-size: 26px;
}

.demo-page p {
    margin-bottom: 30px;
    color: #555;
    font-size: 15px;
    line-height: 1.5;
}

.button-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.demo-page a.button {
    background-color: #0f766e;
    color: #fff;
    padding: 12px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    transition: background 0.3s, transform 0.2s;
}
.demo-page a.button:hover {
    background-color: #115e59;
    transform: translateY(-2px);
}

.demo-page a.back-button {
    background-color: #f44336;
}
.demo-page a.back-button:hover {
    background-color: #e53935;
}
</style>
</head>
<body>
    <div class="demo-page">
        <h2>Message Ready to Send</h2>
        <p>Your message is ready to be sent via WhatsApp. Click below to proceed.</p>
        <div class="button-container">
            <a href="<?php echo $whatsappUrl; ?>" class="button" target="_blank">Send WhatsApp Message</a>
            <a href="index.php" class="button back-button">Back</a>
        </div>
    </div>
</body>
</html>