<?php
// Get current page
$current_page = basename($_SERVER['PHP_SELF']);

// Define menu items
$menu_items = [
    'dashboard.php' => ['label' => 'Dashboard', 'icon' => '📊'],
    'index.php' => ['label' => 'Home', 'icon' => '🏠'],
    'detail.php' => ['label' => 'Details', 'icon' => '📋'],
    'edit.php' => ['label' => 'Edit', 'icon' => '✏️'],
    'logout.php' => ['label' => 'Logout', 'icon' => '🚪'],
];
?>
<div class="side-nav">
    <ul>
        <?php foreach ($menu_items as $file => $item): ?>
            <li>
                <a href="<?php echo $file; ?>" class="<?php echo $current_page == $file ? 'active' : ''; ?>">
                    <span class="icon"><?php echo $item['icon']; ?></span>
                    <span class="label"><?php echo $item['label']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<style>
.side-nav {
    width: 220px;
    background: #2c3e50;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
    transition: width 0.3s;
}
.side-nav ul { list-style: none; margin: 0; padding: 0; }
.side-nav ul li { margin-bottom: 5px; }
.side-nav ul li a {
    display: flex;
    align-items: center;
    color: #ecf0f1;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}
.side-nav ul li a:hover { background: #34495e; padding-left: 25px; }
.side-nav ul li a.active { background: #1abc9c; color: #fff; }
.side-nav ul li a .icon { margin-right: 10px; font-size: 18px; }
.side-nav ul li a .label { display: inline; }
@media(max-width:768px) {
    .side-nav { width: 60px; }
    .side-nav ul li a { justify-content: center; padding: 10px; }
    .side-nav ul li a .label { display: none; }
}
</style>