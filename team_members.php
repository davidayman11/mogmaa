<?php
session_start();
require_once 'db.php';

$team = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';

if (!$team) {
    die("No team specified.");
}

$result = $conn->query("SELECT name FROM employees WHERE team='$team'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Team Members - <?= htmlspecialchars($team) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        .container { width: 90%; margin: auto; padding-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        table th { background: #007bff; color: white; }
        tr:hover { background: #f1f1f1; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
<div class="container">
    <h2>Members of <?= htmlspecialchars($team) ?></h2>
    <a href="teams.php">⬅ Back to Teams</a>
    <table>
        <thead>
            <tr>
                <th>Member Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>