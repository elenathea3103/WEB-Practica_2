<?php
require_once 'includes/config.php';
$app = Applications::getInstance();
$app->init($dbConfig);
$conn = $app->getConexionBd();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Order History - Bistro FDI</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background: #fdf2f4;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            border-bottom: 2px solid #cca3bb;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background-color: #fef9fa;
            color: #b089a0;
        }

        .status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-new {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cooking {
            background: #fff3cd;
            color: #856404;
        }

        .status-ready {
            background: #d4edda;
            color: #155724;
        }

        .status-finished {
            background: #e2e3e5;
            color: #383d41;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            background-color: #f2c7ce;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            border: 1px solid #cca3bb;
            transition: 0.3s;
            margin-bottom: 25px;
        }

        .back-btn:hover {
            background-color: #eeb8c1;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="index.php" class="back-btn">🏠 Back to Dashboard</a>
        <h1>📋 My Order History</h1>

        <?php
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()):
                        $status_class = strtolower(str_replace(' ', '-', $row['status']));
                        ?>
                        <tr>
                            <td><strong>#<?= $row['daily_number'] ?></strong></td>
                            <td><?= date('d M Y, H:i', strtotime($row['order_date'])) ?></td>
                            <td><?= $row['type'] ?></td>
                            <td><?= number_format($row['total_price'], 2) ?> €</td>
                            <td>
                                <span class="status status-<?= $status_class ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You haven't placed any orders yet. <a href="order_type.php">Start ordering now!</a></p>
        <?php endif; ?>
    </div>

</body>

</html>