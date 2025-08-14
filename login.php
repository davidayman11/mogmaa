<?php
// login.php
require_once 'includes/auth.php';

// If already logged in redirect
if (is_admin()) {
    header('Location: detail.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (check_admin_credentials($user, $pass)) {
        do_admin_login($user);
        header('Location: detail.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <style>
    body{font-family:Arial; background:#f4f4f4; margin:0; padding:0}
    .box{width:320px;margin:80px auto;padding:20px;background:#fff;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.08)}
    input{width:100%;padding:8px;margin:8px 0;border:1px solid #ccc;border-radius:4px}
    button{width:100%;padding:10px;background:#4CAF50;color:#fff;border:0;border-radius:4px;cursor:pointer}
    .error{color:#c00;margin-bottom:8px}
  </style>
</head>
<body>
  <div class="box">
    <h3 style="margin:0 0 10px">Admin Login</h3>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post">
      <input name="username" placeholder="Username" required autofocus>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p style="font-size:12px;color:#666;margin-top:10px">User: <strong>admin</strong> / Pass: <strong>password</strong></p>
  </div>
</body>
</html>