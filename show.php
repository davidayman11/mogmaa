<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Detailed error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Database connection
    $servername = "shamandorascout.com"; // or 'localhost' if on the same server
    $username = "u968010081_mogamaa";
    $password = "Mogamaa_2000";
    $dbname = "u968010081_mogamaa";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Retrieve data from the database
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
