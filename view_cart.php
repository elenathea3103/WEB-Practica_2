<?php
require_once 'includes/config.php';
$app = Applications::getInstance();
$app->init($dbConfig);
$conn = $app->getConexionBd();

$cart = $_SESSION['cart'] ?? [];
$total_final = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Cart - Bistro FDI</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background: #fdf2f4;
        }

        .cart-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .total-box {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-checkout {
            background: #cca3bb;
            color: white;
        }

        .btn-checkout:hover {
            background: #b089a0;
        }

        .remove-link {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9em;
        }

        .remove-link:hover {
            text-decoration: underline;
        }

        .empty-cart-link {
            color: #888;
            text-decoration: none;
            font-size: 0.85em;
        }

        .empty-cart-link:hover {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>🛒 Your Cart</h1>
            <?php if (!empty($cart)): ?>
                <a href="empty_cart.php" class="empty-cart-link" onclick="return confirm('Clear entire cart?')">🗑️ Empty
                    Cart</a>
            <?php endif; ?>
        </div>

        <p>Order Type: <strong><?= $_SESSION['current_order_type'] ?? 'Not selected' ?></strong></p>

        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="menu.php">Go to menu</a></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price (Base)</th>
                        <th>VAT</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $quantity):
                        $res = $conn->query("SELECT * FROM products WHERE id = $id");
                        $p = $res->fetch_assoc();

                        $base_price = $p['base_price'];
                        $vat_rate = $p['vat'];
                        $price_with_vat = $base_price * (1 + $vat_rate / 100);
                        $subtotal = $price_with_vat * $quantity;
                        $total_final += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= $quantity ?></td>
                            <td><?= number_format($base_price, 2) ?> €</td>
                            <td><?= $vat_rate ?>%</td>
                            <td><?= number_format($subtotal, 2) ?> €</td>
                            <td>
                                <a href="remove_from_cart.php?id=<?= $id ?>" class="remove-link">❌ Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                Total (TVA included): <?= number_format($total_final, 2) ?> €
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: space-between;">
                <a href="menu.php" class="btn" style="background: #eee;">+ Add more</a>
                <a href="checkout.php" class="btn btn-checkout">Confirm Order & Pay</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>