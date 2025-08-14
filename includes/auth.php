<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/app.php';

function admin_login(string $user, string $pass): bool {
    if (hash_equals($user, ADMIN_USER) && hash_equals($pass, ADMIN_PASS)) {
        $_SESSION['admin'] = true;
        return true;
    }
    return false;
}
function require_admin(): void {
    if (empty($_SESSION['admin'])) {
        header('Location: ' . url('admin/login.php'));
        exit;
    }
}
function admin_logout(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
?>

