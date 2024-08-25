<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a 4-character unique ID
$id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

// Capture form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$team = $_POST['team'];
$grade = $_POST['grade'];
$payment = $_POST['payment'];

// Handle photo upload
$photoUrl = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoName = basename($_FILES['photo']['name']);
    $photoDir = 'uploads/';
    
    // Create the upload directory if it does not exist
    if (!is_dir($photoDir)) {
        mkdir($photoDir, 0755, true);
    }

    // Sanitize and move the uploaded file
    $photoPath = $photoDir . $id . '_' . $photoName;
    if (move_uploaded_file($photoTmpName, $photoPath)) {
        $photoUrl = 'http://shamandorascout.com/' . $photoPath;
    } else {
        echo "Failed to upload photo.";
        exit();
    }
}

// Insert data into MySQL database
$sql = "INSERT INTO employees (id, name, phone, team, grade, payment, photo_url)
VALUES ('$id', '$name', '$phone', '$team', '$grade', '$payment', '$photoUrl')";

if ($conn->query($sql) === TRUE) {
    // Redirect to the QR code generation page
    header("Location: generate_qrcode.php?id=$id&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&team=" . urlencode($team) . "&grade=" . urlencode($grade) . "&payment=" . urlencode($payment) . "&photo=" . urlencode($photoUrl));
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
