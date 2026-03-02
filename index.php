<?php
require_once 'includes/Applications.php';
require_once 'includes/config.php';

$app = Applications::getInstance();
$app->init($dbConfig);

// check if user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['user_role'];
$avatar = $_SESSION['avatar'] ?: 'assets/avatars/default.jpeg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Bistro FDI</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; margin: 20px; line-height: 1.6; }
        
        h1 { font-size: 2.5em; margin-bottom: 0; }
        h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-top: 20px; }
        
        .header-section { margin-bottom: 20px; }
        .avatar-img { width: 60px; height: 60px; margin-bottom: 10px; display: block; }
        
        .section-box {
            padding: 20px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        
        .waiter-box { background-color: #d1b3ff; } 
        .kitchen-box { background-color: #cca3bb; } 
        .manager-box { background-color: #f2c7ce; } 

        ul { list-style-type: disc; padding-left: 40px; }
        a { color: blue; text-decoration: underline; margin-right: 15px; }
        
        .nav-links { margin: 10px 0; }
        footer { margin-top: 30px; font-size: 0.9em; }
    </style>
</head>
<body>

    <header class="header-section">
        <h1>Bistro FDI</h1>
        <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="avatar-img">
        <p>Welcome, <strong><?= htmlspecialchars($username) ?></strong> (Role: <?= ucfirst($role) ?>)</p>
        <div class="nav-links">
            <a href="profile.php">Edit Profile</a> | <a href="logout.php">Logout</a>
        </div>
    </header>

    <hr>

    <h2>Main Menu</h2>

    <div class="section">
        <h3>Customer Options</h3>
        <ul>
            <li><a href="menu.php">View Menu & Order</a></li>
            <li><a href="order_history.php">My Order History</a></li>
        </ul>
    </div>

    <?php if ($role === 'waiter' || $role === 'manager'): ?>
    <div class="section-box waiter-box">
        <h3>Waiter Options</h3>
        <p style="padding-left: 20px;">
            <a href="manage_payments.php">Manage Payments & Deliveries</a>
        </p>
    </div>
    <?php endif; ?>

    <?php if ($role === 'cook' || $role === 'manager'): ?>
    <div class="section-box kitchen-box">
        <h3>Kitchen Options</h3>
        <p style="padding-left: 20px;">
            <a href="prepare_orders.php">Prepare Orders</a>
        </p>
    </div>
    <?php endif; ?>
    
    <?php if ($role === 'manager' || $role === 'admin'): ?>
<div class="section-box manager-box">
    <h3>Manager Administration</h3>
    <p style="padding-left: 20px;">
        <a href="admin_users.php">Manage User Roles</a>
        <a href="manage_categories.php">Manage Categories</a>
        <a href="product_list.php" >Product Management</a>
        <a href="view_all_orders.php">View All Pending Orders</a>
    </p>
</div>
<?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <li><a href="admin_users.php">Manage Users</a></li>
    <li><a href="product_list.php">Manage Products</a></li>
    
<?php endif; ?>

    <footer>
        <p>&copy; 2026 Bistro FDI Project - Aplicaciones Web</p>
    </footer>

</body>
</html>