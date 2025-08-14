<?php
/**
 * Enhanced WhatsApp Handler
 * Handles WhatsApp message generation and sending with improved functionality
 */

require_once 'config.php';
require_once 'utils.php';

class WhatsAppHandler {
    
    public function generateMessage($data) {
        try {
            // Validate required fields
            $requiredFields = ['name', 'phone', 'serialNumber', 'qrCodeImageUrl'];
            $validationErrors = Utils::validateRequired($requiredFields, $data);
            
            if (!empty($validationErrors)) {
                throw new Exception('Missing required fields: ' . implode(', ', $validationErrors));
            }
            
            // Sanitize input data
            $name = Utils::sanitizeInput($data['name']);
            $phone = Utils::sanitizeInput($data['phone']);
            $serialNumber = Utils::sanitizeInput($data['serialNumber']);
            $qrCodeImageUrl = Utils::sanitizeInput($data['qrCodeImageUrl']);
            $team = isset($data['team']) ? Utils::sanitizeInput($data['team']) : '';
            $payment = isset($data['payment']) ? Utils::sanitizeInput($data['payment']) : '';
            
            // Validate phone number
            if (!Utils::validatePhone($phone)) {
                throw new Exception('Invalid phone number format.');
            }
            
            // Create personalized message
            $message = $this->createMessage($name, $serialNumber, $qrCodeImageUrl, $team, $payment);
            
            // Format phone for WhatsApp
            $formattedPhone = Utils::formatPhoneForWhatsApp($phone);
            
            // Generate WhatsApp URL
            $whatsappUrl = Utils::generateWhatsAppURL($formattedPhone, $message);
            
            return [
                'success' => true,
                'message' => $message,
                'whatsapp_url' => $whatsappUrl,
                'formatted_phone' => $formattedPhone
            ];
            
        } catch (Exception $e) {
            Utils::logError('WhatsApp message generation failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function createMessage($name, $serialNumber, $qrCodeImageUrl, $team = '', $payment = '') {
        $englishMessage = "Hello $name,\n\n";
        $englishMessage .= "Thank you for registering with " . APP_NAME . "!\n\n";
        $englishMessage .= "📋 Registration Details:\n";
        $englishMessage .= "• Serial Number: $serialNumber\n";
        
        if ($team) {
            $englishMessage .= "• Team: $team\n";
        }
        
        if ($payment) {
            $englishMessage .= "• Payment Amount: $payment\n";
        }
        
        $englishMessage .= "\n🎫 Your Ticket: $qrCodeImageUrl\n\n";
        $englishMessage .= "⚠️ Important: Please save this number to view your ticket.\n";
        $englishMessage .= "📱 Keep this message for your records.\n\n";
        
        $arabicMessage = "مرحباً $name،\n\n";
        $arabicMessage .= "شكراً لتسجيلك في " . APP_NAME . "!\n\n";
        $arabicMessage .= "📋 تفاصيل التسجيل:\n";
        $arabicMessage .= "• رقم التسلسل: $serialNumber\n";
        
        if ($team) {
            $arabicMessage .= "• الفريق: $team\n";
        }
        
        if ($payment) {
            $arabicMessage .= "• مبلغ الدفع: $payment\n";
        }
        
        $arabicMessage .= "\n🎫 تذكرتك: $qrCodeImageUrl\n\n";
        $arabicMessage .= "⚠️ مهم: برجاء حفظ رقم الهاتف المرسل منه الرسالة حتى يمكنك فتح الرابط.\n";
        $arabicMessage .= "📱 احتفظ بهذه الرسالة للرجوع إليها.\n\n";
        
        return $englishMessage . "---\n\n" . $arabicMessage;
    }
    
    public function createCustomMessage($template, $data) {
        try {
            // Replace placeholders in template
            $placeholders = [
                '{name}' => $data['name'] ?? '',
                '{serialNumber}' => $data['serialNumber'] ?? '',
                '{team}' => $data['team'] ?? '',
                '{payment}' => $data['payment'] ?? '',
                '{qrCodeImageUrl}' => $data['qrCodeImageUrl'] ?? '',
                '{appName}' => APP_NAME,
                '{date}' => date('Y-m-d H:i:s')
            ];
            
            $message = str_replace(array_keys($placeholders), array_values($placeholders), $template);
            
            return [
                'success' => true,
                'message' => $message
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function validateWhatsAppUrl($url) {
        return strpos($url, 'https://api.whatsapp.com/send') === 0;
    }
    
    public function generateQRCodeForWhatsApp($whatsappUrl) {
        try {
            $qrData = "WhatsApp: $whatsappUrl";
            $qrCodeUrl = Utils::generateQRCodeURL($qrData, '300x300');
            
            return [
                'success' => true,
                'qr_url' => $qrCodeUrl,
                'qr_data' => $qrData
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function logWhatsAppSend($data) {
        try {
            $logData = [
                'timestamp' => date('Y-m-d H:i:s'),
                'name' => $data['name'] ?? '',
                'phone' => $data['phone'] ?? '',
                'serial_number' => $data['serialNumber'] ?? '',
                'status' => 'sent'
            ];
            
            Utils::logError('WhatsApp message sent', $logData);
            
        } catch (Exception $e) {
            Utils::logError('Failed to log WhatsApp send', ['error' => $e->getMessage()]);
        }
    }
}
?>

