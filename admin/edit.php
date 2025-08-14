<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$id = strtoupper(trim($_GET['id'] ?? ''));
if ($id === '') { echo '<div class="alert alert-danger">Missing ID</div>'; require __DIR__ . '/../includes/footer.php'; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name    = trim($_POST['name'] ?? '');
    $phone   = normalize_phone(trim($_POST['phone'] ?? ''));
    $team    = trim($_POST['team'] ?? '');
    $grade   = trim($_POST['grade'] ?? '');
    $payment = trim($_POST['payment'] ?? '');

    $stmt = $conn->prepare('UPDATE employees SET name=?, phone=?, team=?, grade=?, payment=? WHERE id=?');
    $stmt->bind_param('ssssss', $name, $phone, $team, $grade, $payment, $id);
    if ($stmt->execute()) {
        header('Location: ' . url('admin/dashboard.php'));
        exit;
    } else {
        echo '<div class="alert alert-danger">Update failed</div>';
    }
}

$stmt = $conn->prepare('SELECT * FROM employees WHERE id=?');
$stmt->bind_param('s', $id);
$stmt->execute();
$emp = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$emp) { echo '<div class="alert alert-warning">Not found</div>'; require __DIR__ . '/../includes/footer.php'; exit; }
?>
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card p-4">
      <h1 class="h5">Edit Registration</h1>
      <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control" name="name" value="<?= e($emp['name']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input class="form-control" name="phone" value="+<?= e($emp['phone']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Team</label>
          <input class="form-control" name="team" value="<?= e($emp['team']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Grade</label>
          <input class="form-control" name="grade" value="<?= e($emp['grade']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Payment</label>
          <input class="form-control" name="payment" value="<?= e($emp['payment']) ?>" required>
        </div>
        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary" href="<?= e(url('admin/dashboard.php')) ?>">Cancel</a>
          <button class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

