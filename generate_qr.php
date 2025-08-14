<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'utils.php';
require_once 'qr_handler.php';

$auth = new Auth();
$pageTitle = 'Generating QR Code';

// Check if registration data exists in session
if (!isset($_SESSION['registration_data'])) {
    Utils::redirect('index.php', 'No registration data found. Please register first.', 'error');
}

$registrationData = $_SESSION['registration_data'];
$qrHandler = new QRHandler();

// Generate QR code
$qrResult = $qrHandler->generateQRCode($registrationData);

if (!$qrResult['success']) {
    Utils::redirect('index.php', 'Failed to generate QR code: ' . $qrResult['error'], 'error');
}

// Store QR code info in session for WhatsApp
$_SESSION['qr_code_data'] = [
    'name' => $registrationData['name'],
    'phone' => $registrationData['phone'],
    'serialNumber' => $registrationData['id'],
    'qrCodeImageUrl' => $qrResult['file_url'],
    'team' => $registrationData['team'],
    'payment' => $registrationData['payment']
];

// Clear registration data from session
unset($_SESSION['registration_data']);

require_once 'includes/header.php';
?>

<div class="container">
    <?php require_once 'includes/navigation.php'; ?>
    
    <div class="demo-page-content">
        <div class="text-center mb-4">
            <h1>🎉 Registration Successful!</h1>
            <p class="text-secondary">Your QR code has been generated successfully.</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Your Digital Ticket</h3>
                        <p class="mb-0">Save this QR code for event entry</p>
                    </div>
                    
                    <div class="card-body text-center">
                        <div class="qr-code-container mb-4">
                            <img src="<?php echo htmlspecialchars($qrResult['file_url']); ?>" 
                                 alt="QR Code for <?php echo htmlspecialchars($registrationData['name']); ?>"
                                 class="qr-code-image">
                        </div>
                        
                        <div class="registration-details">
                            <h4>Registration Details</h4>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <strong>Name:</strong>
                                    <span><?php echo htmlspecialchars($registrationData['name']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Serial Number:</strong>
                                    <span class="serial-number"><?php echo htmlspecialchars($registrationData['id']); ?></span>
                                    <button onclick="MOGMAA.copyToClipboard('<?php echo htmlspecialchars($registrationData['id']); ?>')" 
                                            class="btn btn-sm btn-outline" title="Copy Serial Number">
                                        📋
                                    </button>
                                </div>
                                <div class="detail-item">
                                    <strong>Team:</strong>
                                    <span><?php echo htmlspecialchars($registrationData['team']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Grade:</strong>
                                    <span><?php echo htmlspecialchars($registrationData['grade']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <strong>Payment:</strong>
                                    <span><?php echo htmlspecialchars($registrationData['payment']); ?> EGP</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Phone:</strong>
                                    <span><?php echo htmlspecialchars($registrationData['phone']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="action-buttons mt-4">
                            <a href="send_whatsapp.php" class="btn btn-success btn-lg">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                </svg>
                                Send via WhatsApp
                            </a>
                            
                            <button onclick="downloadQRCode()" class="btn btn-secondary btn-lg">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7,10 12,15 17,10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Download QR Code
                            </button>
                            
                            <button onclick="printTicket()" class="btn btn-outline btn-lg">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6,9 6,2 18,2 18,9"/>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                    <rect x="6" y="14" width="12" height="8"/>
                                </svg>
                                Print Ticket
                            </button>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <strong>Important:</strong> 
                            <ul class="mb-0 text-left">
                                <li>Save your serial number: <strong><?php echo htmlspecialchars($registrationData['id']); ?></strong></li>
                                <li>Keep this QR code safe - you'll need it for event entry</li>
                                <li>Send the QR code to your WhatsApp for easy access</li>
                                <li>Make sure to save the sender's number to view the ticket link</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline">
                ← Register Another Person
            </a>
        </div>
    </div>
    
    </main>
</div>

<style>
.qr-code-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    background: var(--bg-secondary);
    border-radius: var(--border-radius-lg);
    margin: 2rem 0;
}

.qr-code-image {
    max-width: 300px;
    height: auto;
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
}

.registration-details {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: var(--border-radius-lg);
    margin: 2rem 0;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-primary);
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
}

.detail-item strong {
    color: var(--text-primary);
    margin-right: 1rem;
}

.serial-number {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: var(--primary-color);
}

.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.action-buttons .btn {
    min-width: 180px;
}

.alert {
    padding: 1rem;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
}

.alert-info {
    background-color: #e3f2fd;
    color: #1565c0;
    border-left: 4px solid #2196f3;
}

.alert ul {
    margin: 0.5rem 0 0 1rem;
}

@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .action-buttons .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .qr-code-container {
        padding: 1rem;
    }
    
    .qr-code-image {
        max-width: 250px;
    }
}

@media print {
    .demo-page-navigation,
    .action-buttons,
    .site-header,
    .site-footer {
        display: none !important;
    }
    
    .demo-page-content {
        padding: 0;
    }
    
    .card {
        box-shadow: none;
        border: 1px solid #000;
    }
}
</style>

<script>
function downloadQRCode() {
    const qrImage = document.querySelector('.qr-code-image');
    const link = document.createElement('a');
    link.download = 'qr-code-<?php echo htmlspecialchars($registrationData['id']); ?>.png';
    link.href = qrImage.src;
    link.click();
    
    MOGMAA.showFlashMessage('QR code download started!', 'success');
}

function printTicket() {
    window.print();
}

// Auto-focus on serial number for easy copying
document.addEventListener('DOMContentLoaded', function() {
    const serialElement = document.querySelector('.serial-number');
    if (serialElement) {
        serialElement.addEventListener('click', function() {
            MOGMAA.copyToClipboard(this.textContent);
        });
    }
});

// Add some visual feedback
document.querySelectorAll('.btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 150);
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>

