<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['phone']) || !isset($_SESSION['serialNumber']) || !isset($_SESSION['qrCodeImageUrl'])) {
    echo "No data available to send.";
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$serialNumber = $_SESSION['serialNumber'];
$qrCodeImageUrl = $_SESSION['qrCodeImageUrl'];

// Create the WhatsApp message in both English and Arabic
$whatsappMessage = "Hello $name,\n\nThank you for registering with Shamandora Scout. Your Serial Number is: $serialNumber. You can access your ticket here: $qrCodeImageUrl. Please save this number to view your ticket.\n\n" .
                   "مرحباً $name،\n\nشكراً لتسجيلك في Shamandora Scout. رقم التسلسل الخاص بك هو: $serialNumber. يمكنك الوصول إلى تذكرتك هنا: $qrCodeImageUrl. برجاء تسجيل رقم الهاتف المرسل منه الرساله حتي يمكنكم فتح اللينك     .";

$whatsappUrl = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);
$whatsappWebUrl = "https://web.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode($whatsappMessage);

// Clear session data
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['serialNumber']);
unset($_SESSION['qrCodeImageUrl']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send WhatsApp Message</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .whatsapp-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            font-weight: 600;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: #25D366;
            color: white;
        }

        .btn-primary:hover {
            background: #20b358;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #25D366;
        }

        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .info-text {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="whatsapp-icon">
            📱
        </div>
        
        <h1>Message Ready to Send</h1>
        <p class="subtitle">Your registration message is ready to be sent via WhatsApp. Choose your preferred method below.</p>
        
        <div class="info-box">
            <div class="info-title">Having trouble with WhatsApp Desktop on Mac?</div>
            <div class="info-text">If the desktop app closes unexpectedly, try using WhatsApp Web instead. It works directly in your browser without any app issues.</div>
        </div>
        
        <div class="button-group">
            <a href="<?php echo $whatsappUrl; ?>" class="btn btn-primary" target="_blank">
                📱 Open WhatsApp App
            </a>
            
            <a href="<?php echo $whatsappWebUrl; ?>" class="btn btn-secondary" target="_blank">
                🌐 Use WhatsApp Web
            </a>
        </div>
        
        <a href="index.php" class="btn btn-back">
            ← Back to Home
        </a>
    </div>

    <script>
        // Add click tracking and user feedback
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add visual feedback
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Show a helpful message after a delay
        setTimeout(() => {
            const infoBox = document.querySelector('.info-box');
            if (infoBox) {
                infoBox.style.animation = 'pulse 2s infinite';
            }
        }, 3000);
    </script>
</body>
</html>

