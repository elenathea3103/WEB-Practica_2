<?php
require_once 'db.php';

$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          JOIN categories c ON p.category_id = c.id 
          WHERE p.is_active = 1";
$products = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bistro Menu</title>
    <style>
        .menu-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; font-family: sans-serif; }
        .product-card { border: 1px solid #ddd; border-radius: 8px; width: 250px; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .product-card.out-of-stock { opacity: 0.5; background: #f8f8f8; }
        .img-box { height: 150px; background: #eee; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .price-tag { font-size: 1.2em; color: #d147a3; font-weight: bold; }
        .order-btn { background: #28a745; color: white; border: none; padding: 10px; cursor: pointer; text-decoration: none; display: block; margin-top: 10px; border-radius: 4px; }
        .sold-out { color: #dc3545; font-weight: bold; margin-top: 10px; display: block; }
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
    <h1 style="text-align: center;">Our Menu</h1>
    <div class="menu-grid">
        <?php while($p = $products->fetch_assoc()): 
            $final_price = $p['base_price'] * (1 + $p['vat']/100);
            $in_stock = $p['stock'] > 0;
        ?>
            <div class="product-card <?= !$in_stock ? 'out-of-stock' : '' ?>">
                <div class="img-box">
    <?php if (!empty($p['image_url'])): ?>
        <img src="assets/products/<?= htmlspecialchars($p['image_url']) ?>" 
             alt="<?= htmlspecialchars($p['name']) ?>" 
             style="width: 100%; height: 100%; object-fit: cover;">
    <?php else: ?>
        <span style="color: #ccc;">No Image</span>
    <?php endif; ?>
</div>
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p><small><?= htmlspecialchars($p['category_name']) ?></small></p>
                <p class="price-tag"><?= number_format($final_price, 2) ?> €</p>
                
                <?php if($in_stock): ?>
                    <a href="place_order.php?id=<?= $p['id'] ?>" class="order-btn">Add to Cart</a>
                    <p><small>In Stock: <?= $p['stock'] ?></small></p>
                <?php else: ?>
                    <span class="sold-out">OUT OF STOCK</span>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>