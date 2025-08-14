<?php
// Navigation component
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<div class="demo-page">
    <div class="demo-page-navigation">
        <nav>
            <ul>
                <li>
                    <a href="index.php" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                        </svg>
                        <?php echo APP_NAME; ?>
                    </a>
                </li>
                
                <?php if (isset($auth) && $auth->isLoggedIn()): ?>
                <li>
                    <a href="show.php" class="<?php echo $currentPage === 'show' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                            <polyline points="2 17 12 22 22 17"/>
                            <polyline points="2 12 12 17 22 12"/>
                        </svg>
                        Details
                    </a>
                </li>
                
                <li>
                    <a href="ahaly.php" class="<?php echo $currentPage === 'ahaly' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V12H8v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9z"></path>
                        </svg>
                        Ahaly
                    </a>
                </li>
                
                <li>
                    <a href="reports.php" class="<?php echo $currentPage === 'reports' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg>
                        Reports
                    </a>
                </li>
                <?php endif; ?>
                
                <li>
                    <a href="login.php" class="<?php echo $currentPage === 'login' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <?php echo (isset($auth) && $auth->isLoggedIn()) ? 'Admin Panel' : 'Admin Login'; ?>
                    </a>
                </li>
                
                <?php if (isset($auth) && $auth->isLoggedIn()): ?>
                <li>
                    <a href="logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                            <path d="m9 21 5-5-5-5"/>
                            <path d="m20 4-5 5 5 5"/>
                            <path d="M4 7v1a3 3 0 0 0 3 3h11"/>
                        </svg>
                        Logout
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    
    <main class="demo-page-content">

