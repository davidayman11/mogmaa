<?php

define('DB_SERVER', '193.203.168.53');
define('DB_USERNAME', 'u968010081_mogamaa');
define('DB_PASSWORD', 'Mogamaa_2000');
define('DB_NAME', 'u968010081_mogamaa');

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

