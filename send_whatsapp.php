<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
check_csrf();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$phone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$phone || !$message || strlen($message) > 2000) {
    flash('error', 'Invalid phone or message.');
    redirect('whatsapp.php');
}

// Here you can integrate with your gateway or use wa.me deep link redirect
$waUrl = 'https://wa.me/' . rawurlencode($phone) . '?text=' . rawurlencode($message);
flash('success', 'Opening WhatsApp to send your message...');
header('Location: ' . $waUrl);
exit;
