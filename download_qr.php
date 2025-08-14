<?php
if (!isset($_GET['file'])) {
    die("No file specified.");
}

$file = __DIR__ . '/qrcodes/' . basename($_GET['file']);

if (!file_exists($file)) {
    die("File not found.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));

readfile($file);
exit;