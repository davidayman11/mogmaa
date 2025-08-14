<?php
require_once 'db_connection.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
} else {
    $data = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main {
            margin-left: 200px;
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>

<?php include 'sidenav.php'; ?>

<div class="main">
    <h1>Detail Page</h1>
    <?php if ($data): ?>
        <table>
            <?php foreach ($data as $key => $value): ?>
                <tr>
                    <th><?= htmlspecialchars($key) ?></th>
                    <td><?= htmlspecialchars($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No data found for this ID.</p>
    <?php endif; ?>
</div>

</body>
</html>