<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../config/app.php';
$id = strtoupper(trim($_GET['id'] ?? ''));
if ($id === '') { echo '<div class="alert alert-danger">Missing ID</div>'; require __DIR__ . '/../includes/footer.php'; exit; }
$ticketUrl = build_ticket_url($id);
$qrImg = QR_URL . qr_filename($id);
?>
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card p-4 text-center">
      <h2 class="h5">Registration Successful 🎉</h2>
      <p class="text-muted">Save or screenshot your QR. You will also receive it on WhatsApp.</p>
      <img src="<?= e($qrImg) ?>" alt="QR Code" class="img-fluid" style="max-width:260px">
      <div class="mt-3">
        <a class="btn btn-success" href="https://wa.me/?text=<?= rawurlencode('Your Mogamaa QR code: ' . $ticketUrl) ?>" target="_blank">Send to WhatsApp</a>
        <a class="btn btn-outline-primary" href="<?= e($ticketUrl) ?>" target="_blank">Open Ticket</a>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

