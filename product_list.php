<?php
session_start();
require_once 'db.php';
require_once 'Product.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit(); }
$products = Product::getAll($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product List - Bistro</title>
    <style>
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f2c7ce; }
        .price-final { color: #d147a3; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .in-stock { background: #d4edda; color: #155724; }
        .out-stock { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div style="margin: 15px 0;">
    <a href="index.php" style="
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
        background-color: #cca3bb; /* Rozul bistro-ului tău */
        padding: 10px 20px;
        border-radius: 5px;
        font-family: 'Segoe UI', sans-serif;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    ">
        <span style="margin-right: 8px;">🏠</span> Back
    </a>
</div>
    <h1>Manage Products</h1>
    <a href="add_product_form.php" style="background: #cca3bb; padding: 10px; color: white; text-decoration: none;">+ Add Product</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Img</th>
                <th>Name</th>
                <th>Category</th>
                <th>Base Price</th>
                <th>VAT</th>
                <th>Final Price (UX)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($products as $p): 
        $final = $p['base_price'] * (1 + $p['vat']/100);
    ?>
    
    <tr>
        <td><img src="assets/products/<?= htmlspecialchars($p['image_url']) ?>" width="40" alt="product"></td>
        <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
        <td><?= htmlspecialchars($p['category_name']) ?></td>
        <td><?= number_format($p['base_price'], 2) ?> €</td>
        <td><?= $p['vat'] ?>%</td>
        <td style="color: #d147a3; font-weight: bold;"><?= number_format($final, 2) ?> €</td>
        <td>
            <span style="padding: 4px; border-radius: 4px; background: <?= $p['stock'] > 0 ? '#d4edda' : '#f8d7da' ?>">
                Quantity: <?= $p['stock'] ?>
            </span>
            <br>
            <small><?= $p['is_active'] ? 'Visible' : 'Hidden' ?></small>
        </td>
        <td>
            <a href="edit_product.php?id=<?= $p['id'] ?>">Edit</a> | 
            <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')">Del</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</body>
</html>