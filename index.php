<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'utils.php';
require_once 'database.php';

$auth = new Auth();
$pageTitle = 'Registration Form';
$pageDescription = 'MOGMAA 2024 Event Registration System';

// Handle form submission
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!$auth->validateCSRFToken($csrfToken)) {
            throw new Exception('Invalid request. Please refresh the page and try again.');
        }
        
        // Get and sanitize form data
        $formData = [
            'name' => Utils::sanitizeInput($_POST['name'] ?? ''),
            'phone' => Utils::sanitizeInput($_POST['phone'] ?? ''),
            'team' => Utils::sanitizeInput($_POST['team'] ?? ''),
            'grade' => Utils::sanitizeInput($_POST['grade'] ?? ''),
            'payment' => Utils::sanitizeInput($_POST['payment'] ?? '')
        ];
        
        // Validate required fields
        $requiredFields = ['name', 'phone', 'team', 'grade', 'payment'];
        $validationErrors = Utils::validateRequired($requiredFields, $formData);
        
        if (!empty($validationErrors)) {
            $errors = $validationErrors;
        } else {
            // Additional validations
            if (!Utils::validatePhone($formData['phone'])) {
                $errors[] = 'Please enter a valid Egyptian phone number.';
            }
            
            if (!is_numeric($formData['payment']) || $formData['payment'] <= 0) {
                $errors[] = 'Please enter a valid payment amount.';
            }
            
            if (empty($errors)) {
                // Generate unique ID
                $formData['id'] = Utils::generateUniqueId('REG_');
                
                // Store registration in database
                $db = Database::getInstance();
                $sql = "INSERT INTO registrations (id, name, phone, team, grade, payment, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
                
                $db->execute($sql, [
                    $formData['id'],
                    $formData['name'],
                    $formData['phone'],
                    $formData['team'],
                    $formData['grade'],
                    $formData['payment']
                ]);
                
                // Store data in session for QR generation
                $_SESSION['registration_data'] = $formData;
                
                // Redirect to QR generation
                Utils::redirect('generate_qr.php', 'Registration successful! Generating your QR code...', 'success');
            }
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
        Utils::logError('Registration form error', ['error' => $e->getMessage()]);
    }
}

// Generate CSRF token
$csrfToken = $auth->generateCSRFToken();

// Include header
require_once 'includes/header.php';
?>

<div class="container">
    <?php require_once 'includes/navigation.php'; ?>
    
    <div class="demo-page-content">
        <div class="text-center mb-4">
            <h1>Welcome to <?php echo APP_NAME; ?></h1>
            <p class="text-secondary">Register for our exciting event and get your digital ticket!</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5>Please correct the following errors:</h5>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Registration Form</h3>
                        <p class="mb-0">Please fill in all the required information below.</p>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="index.php" data-validate>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="nice-form-group">
                                        <label for="name">Full Name *</label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               required 
                                               placeholder="Enter your full name"
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                               data-tooltip="Please enter your full name as it appears on your ID">
                                        <small>Enter your complete name for the certificate</small>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="nice-form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" 
                                               id="phone" 
                                               name="phone" 
                                               required 
                                               placeholder="01xxxxxxxxx"
                                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                                               data-tooltip="Enter your Egyptian mobile number">
                                        <small>Egyptian mobile number (e.g., 01012345678)</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="nice-form-group">
                                        <label for="team">Team/Group *</label>
                                        <select id="team" name="team" required>
                                            <option value="">Select your team</option>
                                            <option value="Scouts" <?php echo (isset($_POST['team']) && $_POST['team'] === 'Scouts') ? 'selected' : ''; ?>>Scouts</option>
                                            <option value="Guides" <?php echo (isset($_POST['team']) && $_POST['team'] === 'Guides') ? 'selected' : ''; ?>>Guides</option>
                                            <option value="Rangers" <?php echo (isset($_POST['team']) && $_POST['team'] === 'Rangers') ? 'selected' : ''; ?>>Rangers</option>
                                            <option value="Rovers" <?php echo (isset($_POST['team']) && $_POST['team'] === 'Rovers') ? 'selected' : ''; ?>>Rovers</option>
                                            <option value="Leaders" <?php echo (isset($_POST['team']) && $_POST['team'] === 'Leaders') ? 'selected' : ''; ?>>Leaders</option>
                                        </select>
                                        <small>Choose the team you belong to</small>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="nice-form-group">
                                        <label for="grade">Grade/Level *</label>
                                        <select id="grade" name="grade" required>
                                            <option value="">Select your grade</option>
                                            <option value="Beginner" <?php echo (isset($_POST['grade']) && $_POST['grade'] === 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="Intermediate" <?php echo (isset($_POST['grade']) && $_POST['grade'] === 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="Advanced" <?php echo (isset($_POST['grade']) && $_POST['grade'] === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                                            <option value="Expert" <?php echo (isset($_POST['grade']) && $_POST['grade'] === 'Expert') ? 'selected' : ''; ?>>Expert</option>
                                        </select>
                                        <small>Select your current skill level</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="nice-form-group">
                                <label for="payment">Payment Amount (EGP) *</label>
                                <input type="number" 
                                       id="payment" 
                                       name="payment" 
                                       required 
                                       min="1" 
                                       step="0.01"
                                       placeholder="Enter payment amount"
                                       value="<?php echo isset($_POST['payment']) ? htmlspecialchars($_POST['payment']) : ''; ?>"
                                       data-tooltip="Enter the registration fee amount">
                                <small>Registration fee in Egyptian Pounds</small>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                        <polyline points="17,21 17,13 7,13 7,21"/>
                                        <polyline points="7,3 7,8 15,8"/>
                                    </svg>
                                    Register Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Event Information</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>📅 Event Date</h6>
                            <p class="text-secondary">Coming Soon</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>📍 Location</h6>
                            <p class="text-secondary">To be announced</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>💰 Registration Fee</h6>
                            <p class="text-secondary">Varies by category</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>🎯 What's Included</h6>
                            <ul class="text-secondary">
                                <li>Event participation</li>
                                <li>Digital certificate</li>
                                <li>QR code ticket</li>
                                <li>WhatsApp notifications</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Note:</strong> After registration, you'll receive a QR code ticket via WhatsApp. Please save the sender's number to access your ticket.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </main>
</div>

<style>
.alert {
    padding: 1rem;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
}

.alert-danger {
    background-color: #ffebee;
    color: #c62828;
    border-left: 4px solid #f44336;
}

.alert-info {
    background-color: #e3f2fd;
    color: #1565c0;
    border-left: 4px solid #2196f3;
}

.alert ul {
    margin: 0.5rem 0 0 1rem;
}

.field-error {
    color: var(--error-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

input.error,
select.error {
    border-color: var(--error-color);
}

.tooltip {
    position: absolute;
    background: var(--bg-dark);
    color: var(--text-white);
    padding: 0.5rem;
    border-radius: var(--border-radius-sm);
    font-size: 0.875rem;
    z-index: 1000;
    max-width: 200px;
    word-wrap: break-word;
}
</style>

<script>
// Phone number formatting
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) {
        value = value.substring(0, 11);
    }
    e.target.value = value;
});

// Payment validation
document.getElementById('payment').addEventListener('input', function(e) {
    const value = parseFloat(e.target.value);
    if (value < 0) {
        e.target.value = '';
    }
});

// Form preview
function updatePreview() {
    const formData = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        team: document.getElementById('team').value,
        grade: document.getElementById('grade').value,
        payment: document.getElementById('payment').value
    };
    
    // You can add preview functionality here
    console.log('Form data:', formData);
}

// Add event listeners for preview
['name', 'phone', 'team', 'grade', 'payment'].forEach(function(fieldName) {
    const field = document.getElementById(fieldName);
    if (field) {
        field.addEventListener('input', MOGMAA.debounce(updatePreview, 300));
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>

