<?php
session_start();

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

// Get the QR code image data
$qrCodeImageData = file_get_contents($qrCodeUrl);
if ($qrCodeImageData === FALSE) {
    die("Error retrieving QR code image.");
}

// Define the directory to save the QR code image
$uploadDir = 'qrcodes/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Use the serial number as the file name
$qrCodeFileName = $uploadDir . $id . '.png';

// Save the QR code image to the server
if (file_put_contents($qrCodeFileName, $qrCodeImageData) === FALSE) {
    die("Error saving QR code image.");
}

// Create the URL to access the QR code image
$qrCodeImageUrl = 'http://shamandorascout.com/' . $qrCodeFileName;

// Store the image URL in the session for later use
$_SESSION['qrCodeImageUrl'] = $qrCodeImageUrl;
$_SESSION['name'] = $name;
$_SESSION['phone'] = $phone;
$_SESSION['serialNumber'] = $id;
?>

<!-- Display QR Code -->
<h2>QR Code</h2>
<img src="<?php echo $qrCodeImageUrl; ?>" alt="QR Code" style="max-width: 100%; height: auto;">

<!-- Link to share the QR code image via WhatsApp -->
<p>Share this QR code via WhatsApp:</p>
<a href="send_whatsapp.php" target="_blank">
    <button>Send QR Code via WhatsApp</button>
</a>
