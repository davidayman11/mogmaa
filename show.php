<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'utils.php';
require_once 'database.php';

$auth = new Auth();
$pageTitle = 'Registration Details';

// Require admin login
$auth->requireLogin();

$db = Database::getInstance();
$registrations = [];
$totalCount = 0;

try {
    // Get all registrations with pagination
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;
    
    // Count total registrations
    $countSql = "SELECT COUNT(*) as total FROM registrations";
    $countResult = $db->fetch($countSql);
    $totalCount = $countResult['total'];
    
    // Get registrations for current page
    $sql = "SELECT r.*, q.file_path as qr_file_path 
            FROM registrations r 
            LEFT JOIN qr_codes q ON r.id = q.participant_id 
            ORDER BY r.created_at DESC 
            LIMIT ? OFFSET ?";
    $registrations = $db->fetchAll($sql, [$limit, $offset]);
    
    $totalPages = ceil($totalCount / $limit);
    
} catch (Exception $e) {
    Utils::logError('Failed to fetch registrations', ['error' => $e->getMessage()]);
    $error = 'Failed to load registration data.';
}

require_once 'includes/header.php';
?>

<div class="container">
    <?php require_once 'includes/navigation.php'; ?>
    
    <div class="demo-page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Registration Details</h1>
                <p class="text-secondary">Total registrations: <?php echo $totalCount; ?></p>
            </div>
            
            <div class="admin-actions">
                <a href="export.php" class="btn btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-15"/>
                        <polyline points="7,10 12,15 17,10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Data
                </a>
            </div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($registrations)): ?>
            <div class="card">
                <div class="card-body text-center">
                    <h3>No Registrations Found</h3>
                    <p class="text-secondary">There are no registrations in the system yet.</p>
                    <a href="index.php" class="btn btn-primary">Go to Registration Form</a>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-header">
                    <h3>All Registrations</h3>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Serial Number</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Team</th>
                                    <th>Grade</th>
                                    <th>Payment</th>
                                    <th>QR Code</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrations as $reg): ?>
                                <tr>
                                    <td>
                                        <code class="serial-number"><?php echo htmlspecialchars($reg['id']); ?></code>
                                    </td>
                                    <td><?php echo htmlspecialchars($reg['name']); ?></td>
                                    <td>
                                        <a href="tel:<?php echo htmlspecialchars($reg['phone']); ?>">
                                            <?php echo htmlspecialchars($reg['phone']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-team"><?php echo htmlspecialchars($reg['team']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-grade"><?php echo htmlspecialchars($reg['grade']); ?></span>
                                    </td>
                                    <td><?php echo number_format($reg['payment'], 2); ?> EGP</td>
                                    <td>
                                        <?php if ($reg['qr_file_path']): ?>
                                            <a href="<?php echo htmlspecialchars($reg['qr_file_path']); ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-success">
                                                View QR
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No QR</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('M j, Y H:i', strtotime($reg['created_at'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button onclick="viewDetails('<?php echo htmlspecialchars($reg['id']); ?>')" 
                                                    class="btn btn-outline btn-sm">
                                                View
                                            </button>
                                            <button onclick="resendWhatsApp('<?php echo htmlspecialchars($reg['id']); ?>')" 
                                                    class="btn btn-outline btn-sm">
                                                Resend
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php if ($totalPages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Registration pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    </main>
</div>

<style>
.table {
    margin: 0;
}

.table th,
.table td {
    padding: 0.75rem;
    vertical-align: middle;
    border-top: 1px solid var(--border-color);
}

.table thead th {
    background: var(--bg-secondary);
    font-weight: 600;
    border-bottom: 2px solid var(--border-color);
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.02);
}

.serial-number {
    background: var(--bg-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius-sm);
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    cursor: pointer;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: var(--border-radius-sm);
}

.badge-team {
    background: var(--primary-color);
    color: white;
}

.badge-grade {
    background: var(--secondary-color);
    color: white;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.pagination {
    margin: 0;
}

.page-link {
    color: var(--primary-color);
    border: 1px solid var(--border-color);
    padding: 0.5rem 0.75rem;
}

.page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.admin-actions {
    display: flex;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .admin-actions {
        flex-direction: column;
    }
}
</style>

<script>
function viewDetails(serialNumber) {
    // Create a modal or redirect to detailed view
    alert('Viewing details for: ' + serialNumber);
    // You can implement a modal here or redirect to a detailed page
}

function resendWhatsApp(serialNumber) {
    if (confirm('Resend WhatsApp message for registration: ' + serialNumber + '?')) {
        // Implement resend functionality
        MOGMAA.showFlashMessage('WhatsApp resend functionality would be implemented here.', 'info');
    }
}

// Make serial numbers clickable to copy
document.querySelectorAll('.serial-number').forEach(function(element) {
    element.addEventListener('click', function() {
        MOGMAA.copyToClipboard(this.textContent);
    });
    
    element.title = 'Click to copy';
});

// Add search functionality (basic client-side filtering)
function addSearchFunctionality() {
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search registrations...';
    searchInput.className = 'form-control mb-3';
    
    const cardHeader = document.querySelector('.card-header');
    if (cardHeader) {
        cardHeader.appendChild(searchInput);
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', addSearchFunctionality);
</script>

<?php require_once 'includes/footer.php'; ?>

