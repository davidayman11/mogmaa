<?php
// Determine current page dynamically
$current_page = basename($_SERVER['PHP_SELF']);
$menu_items = [
    'index.php' => ['label' => 'Home', 'icon' => '🏠'],
    'detail.php' => ['label' => 'Details', 'icon' => '📋'],
    'edit.php' => ['label' => 'Edit', 'icon' => '✏️'],
    'dashboard.php' => ['label' => 'Dashboard', 'icon' => '📊'], // Added dashboard
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
/* Sidebar container */
.side-nav {
    width: 220px;
    background-color: #2c3e50;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    transition: width 0.3s;
}

/* Menu list */
.side-nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
.side-nav ul li {
    margin-bottom: 5px;
}

/* Menu links */
.side-nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.3s, padding-left 0.3s;
}
.side-nav ul li a:hover {
    background-color: #34495e;
    padding-left: 25px;
}

/* Active page highlighting */
.side-nav ul li a.active {
    background-color: #1abc9c;
    color: #fff;
}

/* Icon style */
.side-nav ul li a .icon {
    margin-right: 10px;
    font-size: 18px;
}

/* Responsive: collapse sidebar */
@media (max-width: 768px) {
    .side-nav {
        width: 60px;
        padding-top: 10px;
    }
    .side-nav ul li a {
        padding: 10px 12px;
        justify-content: center;
    }
    .side-nav ul li a .label {
        display: none;
    }
    .side-nav ul li a .icon {
        margin: 0;
        font-size: 20px;
    }
}
</style>