<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/../includes/db.php'; // Adjust path if needed
require __DIR__ . '/../includes/functions.php';

// Optional: check if user is logged in
// if (!isset($_SESSION['user_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container">
    <h1>Welcome to My Web App</h1>
    <p>This is the public homepage. You can customize it as you like.</p>

    <section>
        <h2>Database Test</h2>
        <?php
        try {
            $sql = "SELECT NOW() AS current_time";
            $stmt = $pdo->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Database connected successfully. Current time: <strong>" . htmlspecialchars($row['current_time']) . "</strong></p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>