<?php
// detail.php
require_once 'db.php'; // DB connection

// Fetch data from your table (example: `users`)
$sql = "SELECT * FROM employees ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; }
        .content { padding: 20px; flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <?php include 'side_nav.php'; ?> <!-- Side navigation -->

    <div class="content">
        <h2>Details Page</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <?php while ($field = $result->fetch_field()): ?>
                            <th><?php echo htmlspecialchars($field->name); ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result->data_seek(0); // reset pointer
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</body>
</html>