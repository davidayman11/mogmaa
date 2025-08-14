<?php
// send_whatsapp.php
session_start();

// Check session
if (!isset($_SESSION['name'], $_SESSION['phone'], $_SESSION['serialNumber'], $_SESSION['qrCodeImageUrl'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];
$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];

// WhatsApp message
$whatsappMessage = "Hello $name,\n\nThank you for registering with Shamandora Scout. Your Serial Number is: $serialNumber. You can access your ticket here: $qrCodeImageUrl.";

// WhatsApp URL
$whatsappUrl = "https://wa.me/" . urlencode($phone) . "?text=" . urlencode($whatsappMessage);

// Clear session
unset($_SESSION['name'], $_SESSION['phone'], $_SESSION['serialNumber'], $_SESSION['qrCodeImageUrl']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send WhatsApp Message</title>
<style>
body { font-family:'Segoe UI', Arial, sans-serif; background:#f4f4f4; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
.container { background:#fff; padding:30px 50px; border-radius:12px; box-shadow:0 8px 25px rgba(0,0,0,0.1); text-align:center; max-width:450px; width:100%; }
.container h2 { color:#0f766e; margin-bottom:20px; }
.container p { color:#555; margin-bottom:30px; }
.button-container { display:flex; justify-content:center; gap:15px; flex-wrap:wrap; }
.button { background:#0f766e; color:#fff; padding:12px 22px; border-radius:8px; text-decoration:none; font-size:16px; font-weight:600; transition:0.2s; }
.button:hover { background:#115e59; transform:translateY(-2px); }
.back-button { background:#f44336; }
.back-button:hover { background:#e53935; }
</style>
</head>
<body>
<div class="container">
    <h2>Message Ready to Send</h2>
    <p>Your message will open in WhatsApp and also download automatically as a text file.</p>
    <div class="button-container">
        <a href="<?php echo $whatsappUrl; ?>" onclick="downloadMessage('<?php echo addslashes($whatsappMessage); ?>', '<?php echo addslashes($name); ?>')" target="_self" class="button">Send WhatsApp & Download</a>
        <a href="index.php" class="button back-button">Back</a>
    </div>
</div>

<script>
function downloadMessage(message, name) {
    // Create a text blob
    const blob = new Blob([message], { type: "text/plain" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = name + "_message.txt"; // Use member name for file
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
</body>
</html>