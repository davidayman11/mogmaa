<?php
$servername = '193.203.168.53';
$username   = 'u968010081_mogamaa';
$password   = 'Mogamaa_2000';
$dbname     = 'u968010081_mogamaa';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>

