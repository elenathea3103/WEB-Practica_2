<?php
session_start();
require_once 'db.php';
require_once 'Product.php';


if (!isset($_SESSION['login']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$products = Product::getAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bistro - Manage Products</title>
    <style>table { width: 100%; border-collapse: collapse; } td, th { border: 1px solid #ddd; padding: 8px; }</style>
</head>
<body>
    <h1>Manage Products</h1>
    <p>Logged in as: <?= $_SESSION['username'] ?></p>
    <a href="index.php">Dashboard</a> | <a href="add_product_form.php">Add Product</a>
    <hr>
    <table>
        <tr><th>Name</th><th>Base Price</th><th>VAT</th><th>Final Price</th></tr>
        <?php foreach ($products as $p): 
            $final = $p['base_price'] * (1 + $p['vat']/100);
        ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['base_price'] ?> €</td>
            <td><?= $p['vat'] ?> %</td>
            <td><strong><?= number_format($final, 2) ?> €</strong></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>