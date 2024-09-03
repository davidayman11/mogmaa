<?php
// Include the database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Retrieve user data based on ID
    $sql = "SELECT * FROM employees WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate QR code image URL based on the serial number
        $serialNumber = $row['id'];
        $qrCodeImageUrl = "http://mogamaa.shamandorascout.com/qrcodes/" . $id . ".png";

        // Create the WhatsApp message with the Arabic name and serial number
        $whatsappMessage = "Hi " . $row['name'] . ", your Serial Number is: " . $id . ". Here is your QR code: " . $qrCodeImageUrl;
        $whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($row['phone']) . "&text=" . urlencode($whatsappMessage);

        // Redirect to WhatsApp
        header("Location: $whatsappUrl");
        exit;
    } else {
        echo "User not found.";
    }
} else {
    echo "No ID provided.";
}

$conn->close();
?>
