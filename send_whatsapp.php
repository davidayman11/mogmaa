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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --shadow-heavy: 0 20px 60px 0 rgba(31, 38, 135, 0.5);
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --border-radius: 20px;
            --border-radius-small: 12px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            z-index: -1;
            animation: backgroundShift 20s ease-in-out infinite;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(1deg); }
        }

        .container {
            background: var(--glass-bg);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-heavy);
            padding: 50px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .whatsapp-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: var(--success-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            box-shadow: 0 15px 40px rgba(17, 153, 142, 0.4);
            position: relative;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .whatsapp-icon::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: var(--success-gradient);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.3;
            animation: ripple 2s infinite;
        }

        @keyframes ripple {
            0% { transform: scale(1); opacity: 0.3; }
            100% { transform: scale(1.2); opacity: 0; }
        }

        h1 {
            color: var(--text-primary);
            margin-bottom: 15px;
            font-size: clamp(28px, 4vw, 36px);
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .subtitle {
            color: var(--text-secondary);
            margin-bottom: 40px;
            font-size: 18px;
            font-weight: 500;
            line-height: 1.6;
        }

        .info-box {
            background: rgba(255, 193, 7, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: var(--border-radius-small);
            padding: 25px;
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--warning-gradient);
        }

        .info-title {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-text {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
        }

        .btn {
            padding: 18px 35px;
            border: none;
            border-radius: var(--border-radius-small);
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 8px 30px rgba(17, 153, 142, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 50px rgba(17, 153, 142, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.8);
            color: var(--text-primary);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 8px 30px rgba(108, 117, 125, 0.4);
        }

        .btn-back:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 50px rgba(108, 117, 125, 0.6);
        }

        .btn:active {
            transform: translateY(-1px) scale(0.98);
        }

        .icon {
            font-size: 20px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        /* Floating particles animation */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float-particle 8s infinite linear;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) rotate(360deg);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 40px 30px;
                margin: 10px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .btn {
                padding: 16px 25px;
                font-size: 14px;
            }
            
            .whatsapp-icon {
                width: 80px;
                height: 80px;
                font-size: 40px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 5px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .subtitle {
                font-size: 16px;
            }
            
            .btn {
                padding: 14px 20px;
                font-size: 13px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --text-primary: #ecf0f1;
                --text-secondary: #bdc3c7;
                --glass-bg: rgba(0, 0, 0, 0.25);
                --glass-border: rgba(255, 255, 255, 0.1);
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        .btn:focus {
            outline: 2px solid #4facfe;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 7s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 8s;"></div>
    </div>

    <div class="container">
        <div class="whatsapp-icon">
            📱
        </div>
        
        <h1>Message Ready to Send</h1>
        <p class="subtitle">Your registration message is ready to be sent via WhatsApp. Choose your preferred method below.</p>
        
        <div class="info-box">
            <div class="info-title">💡 Having trouble with WhatsApp Desktop on Mac?</div>
            <div class="info-text">If the desktop app closes unexpectedly, try using WhatsApp Web instead. It works directly in your browser without any app issues.</div>
        </div>
        
        <div class="button-group">
            <a href="<?php echo $whatsappUrl; ?>" class="btn btn-primary" target="_blank">
                <span class="icon">📱</span>
                Open WhatsApp App
            </a>
            
            <a href="<?php echo $whatsappWebUrl; ?>" class="btn btn-secondary" target="_blank">
                <span class="icon">🌐</span>
                Use WhatsApp Web
            </a>
        </div>
        
        <a href="index.php" class="btn btn-back">
            <span class="icon">←</span>
            Back to Home
        </a>
    </div>

    <script>
        // Enhanced click tracking and user feedback
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple-effect 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple effect CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple-effect {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Show success message after delay
        setTimeout(() => {
            const infoBox = document.querySelector('.info-box');
            if (infoBox) {
                infoBox.style.animation = 'pulse 2s infinite';
            }
        }, 3000);

        // Add loading state to buttons when clicked
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if (this.href && this.href.includes('whatsapp')) {
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';
                    
                    setTimeout(() => {
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html>

