<?php
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle filter parameters
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';

// Retrieve unique dates for filter options
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date DESC");
$dates = [];
if ($dates_result->num_rows > 0) {
    while ($date_row = $dates_result->fetch_assoc()) {
        $dates[] = $date_row['date'];
    }
}

// Retrieve unique teams for filter options
$teams_result = $conn->query("SELECT DISTINCT Team FROM employees ORDER BY Team");
$teams = [];
if ($teams_result->num_rows > 0) {
    while ($team_row = $teams_result->fetch_assoc()) {
        $teams[] = $team_row['Team'];
    }
}

// Build the SQL query with filters
$sql = "SELECT * FROM employees WHERE 1=1";
if (!empty($name_filter)) {
    $sql .= " AND Name LIKE '%$name_filter%'";
}
if (!empty($date_filter)) {
    $sql .= " AND DATE(Timestamp) = '$date_filter'";
}
if (!empty($team_filter)) {
    $sql .= " AND Team = '$team_filter'";
}
$sql .= " ORDER BY Timestamp DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24 - Registration Details</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="description" content="MOGAM3'24 Registration Details and Management">
    <meta name="keywords" content="MOGAM3, details, registration, management">
    <style>
        .filters-container {
            background: var(--bg-primary);
            padding: var(--spacing-xl);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-xl);
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
        }
        
        .table-container {
            background: var(--bg-primary);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th,
        .data-table td {
            padding: var(--spacing-md);
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .data-table th {
            background: var(--gray-50);
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            font-size: var(--font-size-sm);
            letter-spacing: 0.5px;
        }
        
        .data-table tr:hover {
            background: var(--gray-50);
        }
        
        .action-buttons {
            display: flex;
            gap: var(--spacing-sm);
        }
        
        .btn-small {
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: var(--font-size-sm);
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-normal);
        }
        
        .btn-edit {
            background: var(--info-color);
            color: var(--text-inverse);
        }
        
        .btn-delete {
            background: var(--error-color);
            color: var(--text-inverse);
        }
        
        .btn-qr {
            background: var(--accent-color);
            color: var(--text-inverse);
        }
        
        .btn-small:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }
        
        .stat-card {
            background: var(--bg-primary);
            padding: var(--spacing-xl);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            text-align: center;
            transition: all var(--transition-normal);
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-number {
            font-size: var(--font-size-3xl);
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            font-size: var(--font-size-sm);
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="demo-page">
        <?php include '../components/sidenav.php'; ?>
        
        <main class="demo-page-content fade-in">
            <section>
                <h1>Registration Details</h1>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <?php
                    // Get total registrations
                    $total_result = $conn->query("SELECT COUNT(*) as total FROM employees");
                    $total_count = $total_result->fetch_assoc()['total'];
                    
                    // Get today's registrations
                    $today_result = $conn->query("SELECT COUNT(*) as today FROM employees WHERE DATE(Timestamp) = CURDATE()");
                    $today_count = $today_result->fetch_assoc()['today'];
                    
                    // Get team count
                    $team_count_result = $conn->query("SELECT COUNT(DISTINCT Team) as teams FROM employees");
                    $team_count = $team_count_result->fetch_assoc()['teams'];
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_count; ?></div>
                        <div class="stat-label">Total Registrations</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $today_count; ?></div>
                        <div class="stat-label">Today's Registrations</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $team_count; ?></div>
                        <div class="stat-label">Active Teams</div>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="filters-container">
                    <h3>Filter Registrations</h3>
                    <form method="GET" action="">
                        <div class="filters-grid">
                            <div class="nice-form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Search by name" value="<?php echo htmlspecialchars($name_filter); ?>">
                            </div>
                            
                            <div class="nice-form-group">
                                <label for="date">Date:</label>
                                <select id="date" name="date">
                                    <option value="">All Dates</option>
                                    <?php foreach ($dates as $date): ?>
                                        <option value="<?php echo $date; ?>" <?php echo ($date_filter == $date) ? 'selected' : ''; ?>>
                                            <?php echo date('Y-m-d', strtotime($date)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="nice-form-group">
                                <label for="team">Team:</label>
                                <select id="team" name="team">
                                    <option value="">All Teams</option>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo htmlspecialchars($team); ?>" <?php echo ($team_filter == $team) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars(ucfirst($team)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: var(--spacing-md);">
                            <input type="submit" value="Apply Filters" class="btn">
                            <a href="show.php" class="btn" style="background: var(--gray-500); text-decoration: none; display: inline-block; text-align: center;">Clear Filters</a>
                        </div>
                    </form>
                </div>
                
                <!-- Data Table -->
                <div class="table-container">
                    <?php if ($result->num_rows > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Team</th>
                                    <th>Grade</th>
                                    <th>Payment</th>
                                    <th>Timestamp</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['ID']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                                        <td><?php echo htmlspecialchars(ucfirst($row['Team'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['Grade']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Payment']); ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($row['Timestamp'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="edit.php?id=<?php echo $row['ID']; ?>" class="btn-small btn-edit">Edit</a>
                                                <a href="delete.php?id=<?php echo $row['ID']; ?>" class="btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                                <a href="generate_qr.php?id=<?php echo $row['ID']; ?>" class="btn-small btn-qr">QR Code</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="padding: var(--spacing-3xl); text-align: center; color: var(--text-secondary);">
                            <h3>No registrations found</h3>
                            <p>No registrations match your current filters.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Add table enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to filter form
            const filterForm = document.querySelector('form');
            if (filterForm) {
                filterForm.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('input[type="submit"]');
                    submitBtn.value = 'Applying Filters...';
                    submitBtn.disabled = true;
                });
            }
            
            // Add confirmation for delete actions
            const deleteLinks = document.querySelectorAll('.btn-delete');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this registration? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>

