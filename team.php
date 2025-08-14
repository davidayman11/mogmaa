<?php
session_start();
require_once 'db.php';
require 'vendor/autoload.php'; // PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$team = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';
if (!$team) {
    die("No team selected.");
}

// --- Get team members ---
$result = $conn->query("SELECT name, payment, phone, email FROM employees WHERE team='$team'");

// --- Export to Excel ---
if (isset($_GET['export_excel'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Team $team");

    // Header
    $sheet->fromArray(['Name', 'Payment', 'Phone', 'Email'], NULL, 'A1');

    // Data
    $rowNum = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue("A$rowNum", $row['name']);
        $sheet->setCellValue("B$rowNum", $row['payment']);
        $sheet->setCellValue("C$rowNum", $row['phone']);
        $sheet->setCellValue("D$rowNum", $row['email']);
        $rowNum++;
    }

    // Output
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$team}_members.xlsx\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Team <?php echo htmlspecialchars($team); ?> Members</title>
<style>
body { font-family:"Segoe UI", Arial, sans-serif; background:#f4f4f4; padding:20px; }
table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; }
th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#0f766e; color:#fff; }
.export-btn { background:#0f766e; color:#fff; padding:8px 15px; border-radius:6px; text-decoration:none; }
.export-btn:hover { background:#0d665b; }
</style>
</head>
<body>

<h1>Team: <?php echo htmlspecialchars($team); ?></h1>
<a href="?team=<?php echo urlencode($team); ?>&export_excel=1" class="export-btn">Download Excel</a>
<table>
<thead>
<tr>
    <th>Name</th>
    <th>Payment</th>
    <th>Phone</th>
    <th>Email</th>
</tr>
</thead>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td>$<?php echo number_format($row['payment'], 2); ?></td>
    <td><?php echo htmlspecialchars($row['phone']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</body>
</html>