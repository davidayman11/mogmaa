<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $mysqli = new mysqli("localhost", "username", "password", "database");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    $grade = $_POST['grade'];
    $payment = $_POST['payment'];
    $serial_number = uniqid(); // Generate a unique serial number

    // Handle file upload
    if (isset($_FILES['photo'])) {
        $file_name = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Define allowed file extensions
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = $serial_number . '.' . $file_ext;
            $upload_dir = 'uploads/';
            move_uploaded_file($file_tmp, $upload_dir . $new_file_name);
        } else {
            echo "Invalid file type.";
            exit;
        }
    }

    $photo_path = isset($new_file_name) ? $upload_dir . $new_file_name : '';

    // Insert data into the database
    $stmt = $mysqli->prepare("INSERT INTO attendees (name, phone, team, grade, payment, photo, serial_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $phone, $team, $grade, $payment, $photo_path, $serial_number);

    if ($stmt->execute()) {
        echo "Data saved successfully.";
        // Generate QR code URL
        $qr_url = "http://yourdomain.com/view.php?serial_number=" . $serial_number;
        echo "<br><a href='$qr_url'>View Details</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
