<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'utils.php';
require_once 'whatsapp_handler.php';

$auth = new Auth();
$pageTitle = 'Send WhatsApp Message';

// Check if QR code data exists in session
if (!isset($_SESSION['qr_code_data'])) {
    Utils::redirect('index.php', 'No QR code data found. Please generate a QR code first.', 'error');
}

$qrData = $_SESSION['qr_code_data'];
$whatsappHandler = new WhatsAppHandler();

// Generate WhatsApp message
$messageResult = $whatsappHandler->generateMessage($qrData);

if (!$messageResult['success']) {
    Utils::redirect('generate_qr.php', 'Failed to generate WhatsApp message: ' . $messageResult['error'], 'error');
}

$whatsappUrl = $messageResult['whatsapp_url'];
$message = $messageResult['message'];

// Log the WhatsApp send attempt
$whatsappHandler->logWhatsAppSend($qrData);

require_once 'includes/header.php';
?>

<div class="container">
    <?php require_once 'includes/navigation.php'; ?>
    
    <div class="demo-page-content">
        <div class="text-center mb-4">
            <h1>📱 Send Your Ticket via WhatsApp</h1>
            <p class="text-secondary">Your message is ready to be sent to your phone</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-header">
                        <h3>WhatsApp Message Preview</h3>
                        <p class="mb-0">Review your message before sending</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="message-preview">
                                    <h4>Message Content</h4>
                                    <div class="whatsapp-message">
                                        <div class="message-bubble">
                                            <pre class="message-text"><?php echo htmlspecialchars($message); ?></pre>
                                        </div>
                                    </div>
                                    
                                    <div class="message-details mt-3">
                                        <h5>Recipient Details</h5>
                                        <div class="detail-row">
                                            <strong>Name:</strong>
                                            <span><?php echo htmlspecialchars($qrData['name']); ?></span>
                                        </div>
                                        <div class="detail-row">
                                            <strong>Phone:</strong>
                                            <span><?php echo htmlspecialchars($qrData['phone']); ?></span>
                                        </div>
                                        <div class="detail-row">
                                            <strong>Serial Number:</strong>
                                            <span class="serial-number"><?php echo htmlspecialchars($qrData['serialNumber']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="qr-preview">
                                    <h4>QR Code Preview</h4>
                                    <div class="qr-container">
                                        <img src="<?php echo htmlspecialchars($qrData['qrCodeImageUrl']); ?>" 
                                             alt="QR Code" 
                                             class="qr-image">
                                    </div>
                                    
                                    <div class="qr-info mt-3">
                                        <p class="text-secondary">
                                            This QR code will be included in your WhatsApp message.
                                            Make sure to save the sender's number to access the link.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="action-section mt-4">
                            <div class="text-center">
                                <h4>Send Options</h4>
                                <p class="text-secondary mb-4">Choose how you want to send your ticket</p>
                                
                                <div class="send-buttons">
                                    <a href="<?php echo htmlspecialchars($whatsappUrl); ?>" 
                                       target="_blank" 
                                       class="btn btn-success btn-lg"
                                       onclick="trackWhatsAppSend()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                        </svg>
                                        Send via WhatsApp
                                    </a>
                                    
                                    <button onclick="copyMessage()" class="btn btn-secondary btn-lg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                        </svg>
                                        Copy Message
                                    </button>
                                    
                                    <button onclick="shareMessage()" class="btn btn-outline btn-lg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="18" cy="5" r="3"/>
                                            <circle cx="6" cy="12" r="3"/>
                                            <circle cx="18" cy="19" r="3"/>
                                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                                        </svg>
                                        Share
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="instructions mt-4">
                            <div class="alert alert-info">
                                <h5>📋 Instructions:</h5>
                                <ol>
                                    <li>Click "Send via WhatsApp" to open WhatsApp with your message</li>
                                    <li>The message will be pre-filled - just click send</li>
                                    <li><strong>Important:</strong> Save the sender's number to access your ticket link later</li>
                                    <li>Keep your serial number safe: <strong><?php echo htmlspecialchars($qrData['serialNumber']); ?></strong></li>
                                </ol>
                            </div>
                            
                            <div class="alert alert-warning">
                                <h5>⚠️ Important Notes:</h5>
                                <ul>
                                    <li>Make sure WhatsApp is installed on your device</li>
                                    <li>The QR code link will only work if you save the sender's number</li>
                                    <li>Keep this message for your records</li>
                                    <li>Contact support if you have any issues</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="navigation-buttons text-center mt-4">
            <a href="generate_qr.php" class="btn btn-outline">
                ← Back to QR Code
            </a>
            
            <a href="index.php" class="btn btn-outline">
                Register Another Person
            </a>
        </div>
    </div>
    
    </main>
</div>

<style>
.message-preview {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--border-radius-lg);
    height: 100%;
}

.whatsapp-message {
    background: #e5ddd5;
    padding: 1rem;
    border-radius: var(--border-radius);
    margin: 1rem 0;
    min-height: 200px;
    position: relative;
}

.message-bubble {
    background: #dcf8c6;
    padding: 1rem;
    border-radius: 18px 18px 4px 18px;
    max-width: 90%;
    margin-left: auto;
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.message-bubble::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: -8px;
    width: 0;
    height: 0;
    border-left: 8px solid #dcf8c6;
    border-bottom: 8px solid transparent;
}

.message-text {
    font-family: 'Roboto', sans-serif;
    font-size: 0.9rem;
    line-height: 1.4;
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    color: #333;
}

.message-details {
    background: var(--bg-primary);
    padding: 1rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.detail-row:last-child {
    border-bottom: none;
}

.qr-preview {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--border-radius-lg);
    height: 100%;
    text-align: center;
}

.qr-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
    background: var(--bg-primary);
    border-radius: var(--border-radius);
    margin: 1rem 0;
}

.qr-image {
    max-width: 200px;
    height: auto;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius-sm);
}

.action-section {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: var(--border-radius-lg);
    border: 2px dashed var(--primary-color);
}

.send-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.send-buttons .btn {
    min-width: 180px;
}

.instructions {
    margin-top: 2rem;
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

.alert-warning {
    background-color: #fff3e0;
    color: #ef6c00;
    border-left: 4px solid #ff9800;
}

.alert ol,
.alert ul {
    margin: 0.5rem 0 0 1rem;
}

.navigation-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.serial-number {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: var(--primary-color);
    background: var(--bg-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius-sm);
}

@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
    
    .send-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .send-buttons .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .navigation-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .navigation-buttons .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .message-bubble {
        max-width: 100%;
    }
    
    .qr-image {
        max-width: 150px;
    }
}
</style>

<script>
const messageText = <?php echo json_encode($message); ?>;
const whatsappUrl = <?php echo json_encode($whatsappUrl); ?>;

function copyMessage() {
    MOGMAA.copyToClipboard(messageText);
}

function shareMessage() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo APP_NAME; ?> - Registration Confirmation',
            text: messageText,
            url: '<?php echo htmlspecialchars($qrData['qrCodeImageUrl']); ?>'
        }).then(() => {
            MOGMAA.showFlashMessage('Message shared successfully!', 'success');
        }).catch((error) => {
            console.log('Error sharing:', error);
            copyMessage(); // Fallback to copy
        });
    } else {
        copyMessage(); // Fallback for browsers that don't support Web Share API
    }
}

function trackWhatsAppSend() {
    // Track that user clicked the WhatsApp send button
    MOGMAA.showFlashMessage('Opening WhatsApp...', 'info');
    
    // Optional: Send analytics or tracking data
    console.log('WhatsApp send initiated for:', <?php echo json_encode($qrData['serialNumber']); ?>);
}

// Add visual feedback for buttons
document.querySelectorAll('.btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 150);
    });
});

// Auto-copy serial number when clicked
document.querySelectorAll('.serial-number').forEach(function(element) {
    element.addEventListener('click', function() {
        MOGMAA.copyToClipboard(this.textContent);
    });
    
    element.style.cursor = 'pointer';
    element.title = 'Click to copy';
});

// Add animation to message bubble
document.addEventListener('DOMContentLoaded', function() {
    const messageBubble = document.querySelector('.message-bubble');
    if (messageBubble) {
        messageBubble.style.opacity = '0';
        messageBubble.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            messageBubble.style.transition = 'all 0.5s ease';
            messageBubble.style.opacity = '1';
            messageBubble.style.transform = 'translateY(0)';
        }, 300);
    }
});
</script>

<?php 
// Clear QR code data from session after use
unset($_SESSION['qr_code_data']);
require_once 'includes/footer.php'; 
?>

