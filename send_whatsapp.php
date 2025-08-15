<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['phone']) || !isset($_SESSION['serialNumber']) || !isset($_SESSION['qrCodeImageUrl'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = preg_replace('/\D/', '', $_SESSION['phone']); // Keep only numbers
$serialNumber = $_SESSION['serialNumber'];
$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];

// Create the WhatsApp message (English + Arabic)
$whatsappMessage = "Hello $name,\n\n"
    . "Thank you for registering with Shamandora Scout. Your Serial Number is: $serialNumber.\n"
    . "You can access your ticket here: $qrCodeImageUrl. Please save this number to view your ticket.\n\n"
    . "مرحباً $name،\n\n"
    . "شكراً لتسجيلك في Shamandora Scout. رقم التسلسل الخاص بك هو: $serialNumber.\n"
    . "يمكنك الوصول إلى تذكرتك هنا: $qrCodeImageUrl.\n"
    . "برجاء تسجيل رقم الهاتف المرسل منه الرساله حتي يمكنكم فتح اللينك.";

// WhatsApp Web / mobile URL
$whatsappWebUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);
// WhatsApp Desktop chat only (no message)
$whatsappDesktopUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone);

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
            max-width: 500px;
            width: 100%;
        }
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
            color: #555;
        }
        .button-container {
            margin-top: 20px;
        }
        a.button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin: 0 10px;
            display: inline-block;
        }
        a.button:hover {
            background-color: #45a049;
        }
        a.back-button {
            background-color: #f44336;
        }
        a.back-button:hover {
            background-color: #e53935;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            resize: none;
        }
    </style>
</head>
<body>
    <div class="demo-page">
        <h2>Message Ready to Send</h2>
        <p>Your message is ready to be sent via WhatsApp.</p>

        <div id="desktopNotice" style="display:none;">
            <p>⚠ WhatsApp Desktop may not pre-fill messages. Please copy it below and paste in WhatsApp.</p>
            <textarea readonly><?php echo $whatsappMessage; ?></textarea>
            <button onclick="copyMessage()">Copy Message</button>
        </div>

        <div class="button-container">
            <a id="whatsappLink" href="<?php echo $whatsappWebUrl; ?>" class="button" target="_blank">Send WhatsApp Message</a>
            <a href="index.php" class="button back-button">Back</a>
        </div>
    </div>

    <script>
        function copyMessage() {
            const textarea = document.querySelector("textarea");
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Message copied to clipboard!");
        }

        // Detect Windows desktop
        const isWindows = navigator.userAgent.includes("Windows") && !/Mobile|Android|iPhone/i.test(navigator.userAgent);
        if (isWindows) {
            document.getElementById("desktopNotice").style.display = "block";
            document.getElementById("whatsappLink").setAttribute("href", "<?php echo $whatsappDesktopUrl; ?>");
        }
    </script>
</body>
</html>