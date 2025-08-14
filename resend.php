<?php
require_once 'includes/auth.php';
require_admin();
require_once 'db.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: detail.php');
    exit;
}

// Fetch phone and qr_url (if stored)
$stmt = $conn->prepare("SELECT phone, qr_url FROM employees WHERE id=? LIMIT 1");
$stmt->bind_param("s", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $stmt->close();
    header('Location: detail.php');
    exit;
}
$row = $res->fetch_assoc();
$stmt->close();

$phone = $row['phone'] ?? '';
$qr_url = $row['qr_url'] ?? '';

// If qr_url empty, assume standard location qrcodes/{id}.png
if (empty($qr_url)) {
    $possible = 'http://mogamaaa.shamandorascout.com/qrcodes/' . rawurlencode($id) . '.png';
    $qr_url = $possible;
}

// Normalize phone for wa.me: remove non-digits
$phone_digits = preg_replace('/\D+/', '', $phone);

// build message
$message = "Your Mogamaa QR code: $qr_url";
$wa_url = 'https://wa.me/' . $phone_digits . '?text=' . rawurlencode($message);

// Redirect admin's browser to WhatsApp (opens WhatsApp web/mobile)
header('Location: ' . $wa_url);
exit;