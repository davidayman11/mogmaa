<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['phone']) || !isset($_SESSION['serialNumber']) || !isset($_SESSION['qrCodeImageUrl']) || !isset($_SESSION['photo'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];
$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];
$photoUrl = $_SESSION['photo']; // Retrieve the photo URL

// Create the WhatsApp message with a link to the QR code image and photo
$whatsappMessage = "Hi $name, your Serial Number is: $serialNumber.\nHere is your QR code: $qrCodeImageUrl\nAnd your uploaded photo: $photoUrl";
$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['serialNumber']);
unset($_SESSION['qrCodeImageUrl']);
unset($_SESSION['photo']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send WhatsApp Message</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Message Ready to Send</h2>
        <p>Your message is ready to be sent via WhatsApp.</p>
        <a href="<?php echo $whatsappUrl; ?>" class="button" target="_blank">Send WhatsApp Message</a>
    </div>
</body>
</html>
