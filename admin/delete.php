<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/db.php';
$id = strtoupper(trim($_GET['id'] ?? ''));
if ($id) {
    $stmt = $conn->prepare('DELETE FROM employees WHERE id=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
}
header('Location: ' . url('admin/dashboard.php'));
exit;
?>