<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$user_role = strtolower($_SESSION['user_role']); 

if ($user_role !== 'admin' && $user_role !== 'manager') {
    die("Access Denied: You do not have permission to edit products.");
}

if (!isset($_GET['id'])) {
    header("Location: product_list.php");
    exit();
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found!");
}

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - Management</title>
    <style>
        body { font-family: sans-serif; background: #fdf2f4; padding: 40px; }
        .form-container { background: white; padding: 25px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .save-btn { background: #cca3bb; color: white; border: none; padding: 12px; width: 100%; cursor: pointer; font-weight: bold; border-radius: 5px; }
        .save-btn:hover { background: #b089a0; }
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
    <div class="form-container">
        <h2>Edit Product: <?= htmlspecialchars($product['name']) ?></h2>
        <form action="process_edit_product.php" method="POST">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <label>Product Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Category:</label>
            <select name="category_id">
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Base Price (€):</label>
            <input type="number" step="0.01" name="base_price" value="<?= $product['base_price'] ?>" required>

            <label>Stock Quantity:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" min="0">

            <label>VAT Rate:</label>
            <select name="vat">
                <option value="4" <?= ($product['vat'] == 4) ? 'selected' : '' ?>>4%</option>
                <option value="10" <?= ($product['vat'] == 10) ? 'selected' : '' ?>>10%</option>
                <option value="21" <?= ($product['vat'] == 21) ? 'selected' : '' ?>>21%</option>
            </select>

            <label>Visibility:</label>
            <select name="is_active">
                <option value="1" <?= ($product['is_active'] == 1) ? 'selected' : '' ?>>Show in Menu</option>
                <option value="0" <?= ($product['is_active'] == 0) ? 'selected' : '' ?>>Hidden</option>
            </select>
            <label>Stock Quantity:</label>
<input type="number" name="stock" value="<?= $product['stock'] ?>" min="0">

<label>Category:</label>
<select name="category_id">
    <?php while($cat = $categories->fetch_assoc()): ?>
        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
        </option>
    <?php endwhile; ?>
</select>

            <label>Image Name (in assets/):</label>
            <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>">

            <button type="submit" class="save-btn">UPDATE CHANGES</button>
        </form>
        <p style="text-align: center;"><a href="product_list.php">Cancel and Go Back</a></p>
    </div>
</body>
</html>