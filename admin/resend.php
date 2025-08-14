<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$id = strtoupper(trim($_GET['id'] ?? ''));
if ($id === '') { header('Location: ' . url('admin/dashboard.php')); exit; }

$stmt = $conn->prepare('SELECT phone FROM employees WHERE id=?');
$stmt->bind_param('s', $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$res) { header('Location: ' . url('admin/dashboard.php')); exit; }

$phone = $res['phone'];
$ticketUrl = build_ticket_url($id);
$msg = rawurlencode("Your Mogamaa QR code: \n$ticketUrl\n(Keep it safe)");
$wa  = 'https://wa.me/' . $phone . '?text=' . $msg;
header('Location: ' . $wa);
exit;
?>
