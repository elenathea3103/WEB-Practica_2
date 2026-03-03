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
$avatar = $_SESSION['avatar'] ?: 'assets/avatars/default.jpeg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home - Bistro FDI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
            background: #fdf2f4;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #cca3bb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .avatar-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid #cca3bb;
            object-fit: cover;
            margin-right: 20px;
        }

        .welcome-text h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .nav-links a {
            text-decoration: none;
            color: #b089a0;
            font-weight: bold;
            margin-left: 15px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #d147a3;
        }

        h2 {
            color: #333;
            font-size: 22px;
            margin-top: 0;
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .box {
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .box:hover {
            transform: translateY(-3px);
        }

        .box h3 {
            margin-top: 0;
            color: #444;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding-bottom: 8px;
        }

        .customer-box {
            background: #fff;
            border: 1px solid #f2dae5;
        }

        .waiter-box {
            background: #f9f0ff;
            border-left: 5px solid #d1b3ff;
        }

        .kitchen-box {
            background: #fef9fa;
            border-left: 5px solid #cca3bb;
        }

        .manager-box {
            background: #fff5f6;
            border-left: 5px solid #f2c7ce;
        }

        .box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .box ul li {
            margin: 10px 0;
        }

        .box a {
            color: #333;
            text-decoration: none;
            display: block;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .box a:hover {
            background: #cca3bb;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #999;
            font-size: 0.9em;
        }
    </style>
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