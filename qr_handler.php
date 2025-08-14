<?php
/**
 * Enhanced QR Code Handler
 * Handles QR code generation with improved security and error handling
 */

require_once 'config.php';
require_once 'database.php';
require_once 'utils.php';

class QRHandler {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function generateQRCode($data) {
        try {
            // Validate input data
            $requiredFields = ['id', 'name', 'phone', 'team', 'grade', 'payment'];
            $validationErrors = Utils::validateRequired($requiredFields, $data);
            
            if (!empty($validationErrors)) {
                throw new Exception('Missing required fields: ' . implode(', ', $validationErrors));
            }
            
            // Sanitize input data
            $id = Utils::sanitizeInput($data['id']);
            $name = Utils::sanitizeInput($data['name']);
            $phone = Utils::sanitizeInput($data['phone']);
            $team = Utils::sanitizeInput($data['team']);
            $grade = Utils::sanitizeInput($data['grade']);
            $payment = Utils::sanitizeInput($data['payment']);
            
            // Validate phone number
            if (!Utils::validatePhone($phone)) {
                throw new Exception('Invalid phone number format.');
            }
            
            // Prepare QR code data
            $qrData = "Name: $name\nPayment Amount: $payment\nTeam: $team\nGrade: $grade\nID: $id";
            
            // Generate QR code URL
            $qrCodeUrl = Utils::generateQRCodeURL($qrData);
            
            // Get QR code image data
            $qrCodeImageData = $this->fetchQRCodeImage($qrCodeUrl);
            
            if (!$qrCodeImageData) {
                throw new Exception('Failed to generate QR code image.');
            }
            
            // Create directory if it doesn't exist
            Utils::createDirectory(QR_CODE_DIR);
            
            // Generate unique filename
            $fileName = $id . '_' . time() . '.png';
            $filePath = QR_CODE_DIR . $fileName;
            
            // Save QR code image
            if (!file_put_contents($filePath, $qrCodeImageData)) {
                throw new Exception('Failed to save QR code image.');
            }
            
            // Store QR code info in database (optional - for tracking)
            $this->storeQRCodeInfo($id, $name, $phone, $team, $grade, $payment, $filePath);
            
            return [
                'success' => true,
                'file_path' => $filePath,
                'file_url' => $this->getBaseUrl() . $filePath,
                'qr_data' => $qrData
            ];
            
        } catch (Exception $e) {
            Utils::logError('QR Code generation failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function fetchQRCodeImage($url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'user_agent' => 'MOGMAA QR Generator'
            ]
        ]);
        
        return file_get_contents($url, false, $context);
    }
    
    private function storeQRCodeInfo($id, $name, $phone, $team, $grade, $payment, $filePath) {
        try {
            $sql = "INSERT INTO qr_codes (participant_id, name, phone, team, grade, payment, file_path, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                    ON DUPLICATE KEY UPDATE 
                    name = VALUES(name), 
                    phone = VALUES(phone), 
                    team = VALUES(team), 
                    grade = VALUES(grade), 
                    payment = VALUES(payment), 
                    file_path = VALUES(file_path), 
                    updated_at = NOW()";
            
            $this->db->execute($sql, [$id, $name, $phone, $team, $grade, $payment, $filePath]);
        } catch (Exception $e) {
            // Log error but don't fail the QR generation
            Utils::logError('Failed to store QR code info in database', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
        }
    }
    
    private function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . $path . '/';
    }
    
    public function getQRCodeInfo($id) {
        try {
            $sql = "SELECT * FROM qr_codes WHERE participant_id = ?";
            return $this->db->fetch($sql, [$id]);
        } catch (Exception $e) {
            Utils::logError('Failed to retrieve QR code info', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            return null;
        }
    }
    
    public function deleteQRCode($id) {
        try {
            // Get QR code info
            $qrInfo = $this->getQRCodeInfo($id);
            
            if ($qrInfo) {
                // Delete file
                if (file_exists($qrInfo['file_path'])) {
                    unlink($qrInfo['file_path']);
                }
                
                // Delete from database
                $sql = "DELETE FROM qr_codes WHERE participant_id = ?";
                $this->db->execute($sql, [$id]);
                
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            Utils::logError('Failed to delete QR code', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            return false;
        }
    }
}
?>

