<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$user_role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';

if ($user_role !== 'admin' && $user_role !== 'manager') {
    die("Access Denied: You don't have permission to add products.");
}

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product - Bistro</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .box { background: white; padding: 20px; max-width: 500px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, select, textarea { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #cca3bb; border: none; padding: 12px; width: 100%; color: white; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div style="margin: 10px 0 20px 0;">
    <a href="javascript:history.back()" style="
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #444;
        background-color: #eee;
        padding: 8px 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-family: sans-serif;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    " onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#eee'">
        <span style="margin-right: 8px;">⬅</span> Back
    </a>
</div>
<div class="box">
    <h2>Add New Product</h2>
    <form action="process_add_product.php" method="POST">
        <label>Product Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Category:</label>
        <select name="category_id">
            <?php while($c = $categories->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Base Price (€):</label>
        <input type="number" step="0.01" name="base_price" required>

        <label>VAT (%):</label>
        <select name="vat">
            <option value="4">4% (Basic)</option>
            <option value="10" selected>10% (Food)</option>
            <option value="21">21% (Standard)</option>
        </select>

        <label>Stock Quantity:</label>
        <input type="number" name="stock" value="10" min="0">

        <label>Status (Ofertat):</label>
        <select name="is_active">
            <option value="1">Available in Menu</option>
            <option value="0">Hidden / Not in Menu</option>
        </select>

        <label>Image Filename (ex: pizza.jpg):</label>
        <input type="text" name="image_url" placeholder="default.png">

        <button type="submit">SAVE PRODUCT</button>
    </form>
</div>
</body>
</html>