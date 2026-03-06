<?php
require_once 'includes/Applications.php';
require_once 'includes/config.php';

$app = Applications::getInstance();
$app->init($dbConfig);

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['user_role'] ?? 'guest';


$avatar = $_SESSION['avatar'] ?: RUTA_IMG . 'default.jpeg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home - Bistro FDI</title>
    <link rel="stylesheet" href="<?= RUTA_CSS ?>style.css">
</head>

<body>

    <div class="container">
        <header class="header-section">
            <div class="user-info">
                <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="avatar-img">
                <div class="welcome-text">
                    <h1>Bistro FDI</h1>
                    <span>Welcome, <strong><?= htmlspecialchars($username) ?></strong>
                        <small>(<?= ucfirst($role) ?>)</small></span>
                </div>
            </div>
            <div class="nav-links">
                <a href="profile.php">⚙️ Edit Profile</a>
                <a href="logout.php" style="color: #d9534f;">Logout 🚪</a>
            </div>
        </header>

        <h2>Main Menu</h2>

        <div class="section-grid">
            <div class="box customer-box">
                <h3>🛒 Customer Options</h3>
                <ul>
                    <li><a href="order_type.php">Place an Order</a></li>
                    <li><a href="order_history.php">My Order History</a></li>
                </ul>
            </div>

            <?php if ($role === 'waiter' || $role === 'manager' || $role === 'admin'): ?>
                <div class="box waiter-box">
                    <h3>👔 Waiter Options</h3>
                    <ul>
                        <li><a href="manage_payments.php">Manage Payments & Deliveries</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($role === 'cook' || $role === 'manager' || $role === 'admin'): ?>
                <div class="box kitchen-box">
                    <h3>🍳 Kitchen Options</h3>
                    <ul>
                        <li><a href="prepare_orders.php">Prepare Orders</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($role === 'manager' || $role === 'admin'): ?>
                <div class="box manager-box">
                    <h3>📊 Administration</h3>
                    <ul>
                        <li><a href="admin_users.php">Manage User Roles</a></li>
                        <li><a href="manage_categories.php">Manage Categories</a></li>
                        <li><a href="product_list.php">Product Management</a></li>
                        <li><a href="view_all_orders.php">View All Pending Orders</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            <p>&copy; 2026 Bistro FDI Project - Aplicaciones Web</p>
        </footer>
    </div>

</body>

</html>