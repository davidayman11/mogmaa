<?php
/**
 * Utility functions for the MOGMAA website
 * Contains helper functions for common operations
 */

class Utils {
    
    /**
     * Sanitize input data
     */
    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    /**
     * Validate phone number
     */
    public static function validatePhone($phone) {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if it starts with +2 or 2 and has appropriate length
        if (preg_match('/^(\+?2)?01[0-2,5]{1}[0-9]{8}$/', $phone)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Format phone number for WhatsApp
     */
    public static function formatPhoneForWhatsApp($phone) {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present
        if (!str_starts_with($phone, '2')) {
            $phone = '2' . $phone;
        }
        
        return $phone;
    }
    
    /**
     * Generate unique ID
     */
    public static function generateUniqueId($prefix = '') {
        return $prefix . uniqid() . '_' . time();
    }
    
    /**
     * Create directory if it doesn't exist
     */
    public static function createDirectory($path) {
        if (!is_dir($path)) {
            return mkdir($path, 0755, true);
        }
        return true;
    }
    
    /**
     * Log error messages
     */
    public static function logError($message, $context = []) {
        $logMessage = date('Y-m-d H:i:s') . " - " . $message;
        if (!empty($context)) {
            $logMessage .= " - Context: " . json_encode($context);
        }
        error_log($logMessage);
    }
    
    /**
     * Redirect with message
     */
    public static function redirect($url, $message = null, $type = 'info') {
        if ($message) {
            session_start();
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_type'] = $type;
        }
        header("Location: $url");
        exit;
    }
    
    /**
     * Get and clear flash message
     */
    public static function getFlashMessage() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = null;
        $type = 'info';
        
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'] ?? 'info';
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        }
        
        return ['message' => $message, 'type' => $type];
    }
    
    /**
     * Validate required fields
     */
    public static function validateRequired($fields, $data) {
        $errors = [];
        
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[] = ucfirst($field) . " is required.";
            }
        }
        
        return $errors;
    }
    
    /**
     * Generate QR code URL
     */
    public static function generateQRCodeURL($data, $size = null) {
        $size = $size ?? QR_CODE_SIZE;
        $encodedData = urlencode($data);
        return QR_CODE_API_URL . "?size=$size&data=" . $encodedData;
    }
    
    /**
     * Generate WhatsApp URL
     */
    public static function generateWhatsAppURL($phone, $message) {
        $formattedPhone = self::formatPhoneForWhatsApp($phone);
        $encodedMessage = urlencode($message);
        return WHATSAPP_API_URL . "?phone=$formattedPhone&text=$encodedMessage";
    }
}
?>

