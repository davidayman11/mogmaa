<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/csrf.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card p-4">
      <h1 class="h4 mb-3">Register for Mogamaa Fun Day</h1>
      <form method="post" action="submit.php" novalidate>
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">ID (4 chars)</label>
          <input type="text" name="id" maxlength="4" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="tel" name="phone" class="form-control" placeholder="+20XXXXXXXXXX" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Team</label>
          <select name="team" class="form-select" required>
            <option value="" selected disabled>Select team</option>
            <option value="bra3em">bra3em</option>
            <option value="ashbal">ashbal</option>
            <option value="zahrat">zahrat</option>
            <option value="kshafa">kshafa</option>
            <option value="morshdat">morshdat</option>
            <option value="motkadem">motkadem</option>
            <option value="ra2edat">ra2edat</option>
            <option value="gwala">gwala</option>
            <option value="kada">kada</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Grade</label>
          <input type="text" name="grade" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Payment</label>
          <input type="text" name="payment" class="form-control" required>
        </div>
        <button class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
