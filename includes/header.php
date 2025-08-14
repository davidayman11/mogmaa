<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'MOGMAA 2024 Registration System'; ?>">
    <meta name="author" content="MOGMAA Team">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- Additional CSS -->
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="<?php echo isset($bodyClass) ? $bodyClass : ''; ?>">
    
    <!-- Flash Messages -->
    <?php
    $flash = Utils::getFlashMessage();
    if ($flash['message']):
    ?>
    <div class="flash-message flash-<?php echo $flash['type']; ?>">
        <div class="flash-content">
            <span class="flash-text"><?php echo htmlspecialchars($flash['message']); ?></span>
            <button class="flash-close" onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><a href="index.php"><?php echo APP_NAME; ?></a></h1>
                </div>
                
                <?php if (isset($auth) && $auth->isLoggedIn()): ?>
                <div class="user-info">
                    <span class="welcome-text">Welcome, <?php echo htmlspecialchars($auth->getUsername()); ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">

