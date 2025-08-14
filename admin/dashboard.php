<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$q = trim($_GET['q'] ?? '');
$sql = 'SELECT id,name,phone,team,grade,payment FROM employees';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE id LIKE ? OR name LIKE ? OR phone LIKE ? OR team LIKE ? OR grade LIKE ?';
}
$sql .= ' ORDER BY id ASC';

$stmt = $conn->prepare($sql);
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
}
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h5 mb-0">Registrations</h1>
  <div>
    <a href="<?= e(url('public/index.php')) ?>" class="btn btn-success btn-sm">+ New Registration</a>
    <a href="<?= e(url('admin/logout.php')) ?>" class="btn btn-outline-secondary btn-sm">Logout</a>
  </div>
</div>
<form class="input-group mb-3" method="get">
  <input class="form-control" name="q" placeholder="Search name, id, phone, team..." value="<?= e($q) ?>">
  <button class="btn btn-outline-primary">Search</button>
</form>
<div class="table-responsive">
<table class="table align-middle table-hover bg-white">
  <thead class="table-light">
    <tr>
      <th>ID</th><th>Name</th><th>Phone</th><th>Team</th><th>Grade</th><th>Payment</th><th>QR</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php while($row = $res->fetch_assoc()): ?>
    <?php $qr = QR_URL . qr_filename($row['id']); ?>
    <tr>
      <td><?= e($row['id']) ?></td>
      <td><?= e($row['name']) ?></td>
      <td>+<?= e($row['phone']) ?></td>
      <td><?= e($row['team']) ?></td>
      <td><?= e($row['grade']) ?></td>
      <td><?= e($row['payment']) ?></td>
      <td><a href="<?= e($qr) ?>" target="_blank">QR</a></td>
      <td>
        <a class="btn btn-sm btn-primary" href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Delete this record?')">Delete</a>
        <a class="btn btn-sm btn-success" href="resend.php?id=<?= urlencode($row['id']) ?>">Resend</a>
        <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('public/ticket.php?id=' . urlencode($row['id']) . '&sig=' . make_signature($row['id']))) ?>" target="_blank">Ticket</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

