<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
</head>
<body>

<?php
// Retrieve parameters
$id = $_GET['id'];
$name = $_GET['name'];
$phone = $_GET['phone'];
$team = $_GET['team'];
$grade = $_GET['grade'];
$payment = $_GET['payment'];

// Prepare the data string for the QR code
$data = "Name: $name\nPhone Number: $phone\nTeam: $team\nGrade: $grade\nPayment Amount: $payment";

// Encode the data for the QR code URL
$encodedData = urlencode($data);

// Generate the QR code URL
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . $encodedData;

// Get the QR code image data as a base64 encoded string
$qrCodeImageData = base64_encode(file_get_contents($qrCodeUrl));

// Create the data URL for the image
$qrCodeDataUrl = "data:image/png;base64," . $qrCodeImageData;
?>

<!-- Display QR Code -->
<h2>QR Code</h2>
<img src="<?php echo $qrCodeDataUrl; ?>" alt="QR Code" style="max-width: 100%; height: auto;">

<!-- Link to share the QR code image via WhatsApp -->
<p>Share this QR code via WhatsApp:</p>
<a href="whatsapp://send?phone=<?php echo $phone; ?>&text=Here%20is%20your%20QR%20code%20image:" target="_blank">
    <button>Send QR Code via WhatsApp</button>
</a>

</body>
</html>
