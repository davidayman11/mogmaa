<?php
require_once __DIR__ . '/../includes/csrf.php';
verify_csrf();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../lib/phpqrcode/qrlib.php';

$id      = strtoupper(trim($_POST['id'] ?? ''));
$name    = trim($_POST['name'] ?? '');
$phone   = normalize_phone(trim($_POST['phone'] ?? ''));
$team    = trim($_POST['team'] ?? '');
$grade   = trim($_POST['grade'] ?? '');
$payment = trim($_POST['payment'] ?? '');

// Basic validation
$errors = [];
if ($id === '' || strlen($id) !== 4) $errors[] = 'ID must be exactly 4 characters.';
if ($name === '') $errors[] = 'Name is required.';
if ($phone === '') $errors[] = 'Phone is required.';
if ($team === '') $errors[] = 'Team is required.';
if ($grade === '') $errors[] = 'Grade is required.';
if ($payment === '') $errors[] = 'Payment is required.';

if ($errors) {
    http_response_code(422);
    echo 'Validation errors:<br>' . implode('<br>', array_map('e', $errors));
    exit;
}

// Insert (or update if id exists) using prepared statements
$stmt = $conn->prepare("INSERT INTO employees (id, name, phone, team, grade, payment)
                        VALUES (?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE name=VALUES(name), phone=VALUES(phone), team=VALUES(team), grade=VALUES(grade), payment=VALUES(payment)");
$stmt->bind_param('ssssss', $id, $name, $phone, $team, $grade, $payment);
if (!$stmt->execute()) {
    http_response_code(500);
    exit('DB error: ' . e($stmt->error));
}
$stmt->close();

// Generate QR (ticket URL signed)
ensure_qr_dir();
$ticketUrl = build_ticket_url($id);
$file = QR_DIR . qr_filename($id);
QRcode::png($ticketUrl, $file, QR_ECLEVEL_M, 6, 2);
$qrUrl = QR_URL . basename($file);

// WhatsApp link
$message = rawurlencode("Your Mogamaa QR code: \n$ticketUrl\n(Keep it safe)");
$wa = 'https://wa.me/' . $phone . '?text=' . $message;

// Redirect to success page with info
header('Location: success.php?id=' . urlencode($id));
exit;
?>
