<?php
// detail.php
require_once 'db.php'; // DB connection

// Fetch data
$sql = "SELECT * FROM employees ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background: #f4f7f6;
        }
        .content {
            padding: 20px;
            flex: 1;
            overflow-x: auto;
        }
        h2 {
            margin-bottom: 15px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
            text-transform: capitalize;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #eef7ff; }
        .no-data {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 5px;
            margin-top: 15px;
            border: 1px solid #ffeeba;
        }
        /* Mobile responsive */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }
            thead { display: none; }
            tr {
                margin-bottom: 15px;
                background: white;
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 10px;
            }
            td {
                padding: 8px 10px;
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
            }
            td:last-child { border-bottom: none; }
            td:before {
                content: attr(data-label);
                font-weight: bold;
                text-transform: capitalize;
                display: block;
                margin-bottom: 4px;
                color: #555;
            }
        }
    </style>
</head>
<body>

    <?php include 'side_nav.php'; ?> <!-- Side navigation -->

    <div class="content">
        <h2>Employees List</h2>

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
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($row as $key => $value): ?>
                                <td data-label="<?php echo htmlspecialchars($key); ?>">
                                    <?php echo htmlspecialchars($value); ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No employee records found.</div>
        <?php endif; ?>
    </div>

</body>
</html>