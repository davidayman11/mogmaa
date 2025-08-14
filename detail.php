<?php
// detail.php
session_start();
require_once 'db.php'; // Database connection
include 'sidenav.php'; // Side navigation

// Get ID from query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='content'><h2>Invalid record ID</h2></div>";
    exit;
}

// Fetch data from database
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>
<div class="content">
    <h2>Details</h2>
    <?php if ($data): ?>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($data['id']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
        <p><strong>Created:</strong> <?php echo htmlspecialchars($data['created_at']); ?></p>
        <a href="index.php" class="btn">Back</a>
    <?php else: ?>
        <p>No record found.</p>
    <?php endif; ?>
</div>