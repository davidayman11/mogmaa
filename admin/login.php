<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');
    if (admin_login($u, $p)) {
        header('Location: ' . url('admin/dashboard.php'));
        exit;
    } else {
        echo '<div class="alert alert-danger">Invalid credentials</div>';
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h1 class="h5 mb-3">Admin Login</h1>
      <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
