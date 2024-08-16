<?php
// upload_qrcode.php

// Directory to save QR codes
$uploadDir = 'qrcodes/';
$uploadFile = $uploadDir . basename($_FILES['image']['name']);

// Save the uploaded file
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    // Return the URL of the uploaded image
    $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $uploadFile;
    echo json_encode(['imageUrl' => $imageUrl]);
} else {
    echo json_encode(['error' => 'Failed to upload image']);
}
?>
