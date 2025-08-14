<?php
require_once __DIR__ . '/../includes/auth.php';
admin_logout();
header('Location: ' . url('admin/login.php'));
exit;
?>
