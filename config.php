<?php
/**
 * Configuration file for MOGMAA website
 * Contains database connection settings and other configuration options
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'mogmaa_user');
define('DB_PASSWORD', 'mogmaa_pass');
define('DB_NAME', 'mogmaa_db');

// Application settings
define('APP_NAME', 'MOGMAA 2024');
define('APP_VERSION', '2.0');
define('SESSION_TIMEOUT', 3600); // 1 hour

// Security settings
define('PASSWORD_HASH_ALGO', PASSWORD_DEFAULT);
define('CSRF_TOKEN_NAME', 'csrf_token');

// File upload settings
define('UPLOAD_DIR', 'uploads/');
define('QR_CODE_DIR', 'qrcodes/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// WhatsApp API settings
define('WHATSAPP_API_URL', 'https://api.whatsapp.com/send');

// QR Code API settings
define('QR_CODE_API_URL', 'https://api.qrserver.com/v1/create-qr-code/');
define('QR_CODE_SIZE', '600x600');

// Admin credentials (in production, store these securely)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', password_hash('shamandora', PASSWORD_DEFAULT));

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Africa/Cairo');
?>

