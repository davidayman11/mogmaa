<?php
session_start(); // Start the session

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

        // Generate the QR code link or use an existing one
        $qrCodeLink = "https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=" . urlencode($row['name']) . "%20" . urlencode($row['phone']);

        // Send the QR code link via WhatsApp
        $whatsappLink = "https://wa.me/". $row['phone'] . "?text=" . urlencode("Here is your QR code: " . $qrCodeLink);
        header("Location: " . $whatsappLink);
        exit;
    } else {
        echo "User not found.";
    }
} else {
    echo "No ID provided.";
}

$conn->close();
?>
