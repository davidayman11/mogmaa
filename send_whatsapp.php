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

// Create the WhatsApp message with a link to the QR code image
$whatsappMessage = "Hi $name, your Serial Number is: $serialNumber. Here is your QR code: $qrCodeImageUrl";
$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['serialNumber']);
unset($_SESSION['qrCodeImageUrl']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send WhatsApp Message</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .demo-page h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .demo-page p {
            margin-bottom: 30px;
            color: #555;
        }

        .button-container {
            margin-top: 20px;
        }

        .demo-page a.button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin: 0 10px;
        }

        .demo-page a.button:hover {
            background-color: #45a049;
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
        <p>Your message is ready to be sent via WhatsApp.</p>
        <div class="button-container">
            <a href="<?php echo $whatsappUrl; ?>" class="button" target="_blank">Send WhatsApp Message</a>
            <a href="index.php" class="button back-button">Back</a>
        </div>
    </div>
</body>
</html>
