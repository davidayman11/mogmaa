<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/header.php';

$id  = strtoupper(trim($_GET['id'] ?? ''));
$sig = trim($_GET['sig'] ?? '');

if ($id === '' || $sig === '' || !hash_equals(make_signature($id), $sig)) {
    echo '<div class="alert alert-danger">Invalid or tampered ticket.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$stmt = $conn->prepare('SELECT id, name, phone, team, grade, payment FROM employees WHERE id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();
$res = $stmt->get_result();
$emp = $res->fetch_assoc();
$stmt->close();

if (!$emp) {
    echo '<div class="alert alert-warning">Ticket not found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}
$qrImg = QR_URL . qr_filename($id);
?>
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="h5 mb-0">Mogamaa Fun Day Ticket</h1>
        <span class="badge bg-primary">ID: <?= e($emp['id']) ?></span>
      </div>
      <hr>
      <div class="row g-3">
        <div class="col-md-7">
          <dl class="row mb-0">
            <dt class="col-sm-4">Name</dt><dd class="col-sm-8"><?= e($emp['name']) ?></dd>
            <dt class="col-sm-4">Phone</dt><dd class="col-sm-8">+<?= e($emp['phone']) ?></dd>
            <dt class="col-sm-4">Team</dt><dd class="col-sm-8"><?= e($emp['team']) ?></dd>
            <dt class="col-sm-4">Grade</dt><dd class="col-sm-8"><?= e($emp['grade']) ?></dd>
            <dt class="col-sm-4">Payment</dt><dd class="col-sm-8"><?= e($emp['payment']) ?></dd>
          </dl>
        </div>
        <div class="col-md-5 text-center">
          <img src="<?= e($qrImg) ?>" class="img-fluid" alt="QR" style="max-width:220px">
          <div class="small text-muted mt-2">Scan at the gate</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
