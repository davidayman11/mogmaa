<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['phone']) || !isset($_SESSION['serialNumber'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];

// Create the WhatsApp message
$whatsappMessage = "Hi $name, your SN is: $serialNumber";
$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['serialNumber']);
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
