<?php
// includes/db.php
// Centralized PDO connection with secure defaults
declare(strict_types=1);

$DB_HOST = '193.203.168.53';
$DB_NAME = 'u968010081_mogamaa';
$DB_USER = 'u968010081_mogamaa';
$DB_PASS = 'Mogamaa_2000';
$DB_CHARSET = 'utf8mb4';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Return rows as associative arrays
        PDO::ATTR_EMULATE_PREPARES => false,                 // Use native prepared statements
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database connection error.";
    error_log("[DB] " . $e->getMessage()); // Log the actual error securely
    exit;
}