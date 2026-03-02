<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// verify is the client chose a category
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bistro Menu</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #fdf2f4; color: #333; }
        .container { max-width: 1000px; margin: auto; }
        .nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .nav-back { display: inline-flex; align-items: center; text-decoration: none; color: #fff; background-color: #cca3bb; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
        
        .view-cart-btn { 
            display: inline-flex; align-items: center; text-decoration: none; 
            color: #333; background-color: #f2c7ce; padding: 10px 20px; 
            border-radius: 5px; font-weight: bold; border: 1px solid #cca3bb; 
            transition: 0.3s;
        }
        .view-cart-btn:hover { background-color: #eeb8c1; }

        .menu-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top: 20px; }
        
        .category-card { 
            background: white; border-radius: 12px; width: 200px; padding: 25px; 
            text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.08); 
            text-decoration: none; color: #333; transition: 0.3s; border: 2px solid transparent;
        }
        .category-card:hover { transform: translateY(-5px); border-color: #cca3bb; }

        .product-card { background: white; border-radius: 12px; width: 250px; padding: 15px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: relative; }
        .img-box { height: 150px; background: #f9f9f9; border-radius: 8px; overflow: hidden; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; }
        .price-tag { font-size: 1.2em; color: #d147a3; font-weight: bold; }
        .order-btn { background: #cca3bb; color: white; border: none; padding: 10px; cursor: pointer; text-decoration: none; display: block; margin-top: 10px; border-radius: 5px; font-weight: bold; }
        .order-btn:hover { background: #b089a0; }
        .out-of-stock-btn { background: #ccc; cursor: not-allowed; }
        .stock-info { font-size: 0.85em; color: #777; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">

    <?php if ($category_id === 0): ?>
        <a href="index.php" class="nav-back">🏠 Back to Home</a>
        <h1 style="text-align: center;">Select a Category</h1>
        
        <div class="menu-grid">
            <?php
            $categories = $conn->query("SELECT * FROM categories");
            while($cat = $categories->fetch_assoc()): ?>
                <a href="menu.php?id=<?= $cat['id'] ?>" class="category-card">
                    <span style="font-size: 40px;">🍽️</span>
                    <h3><?= htmlspecialchars($cat['name']) ?></h3>
                </a>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <div class="nav-header">
            <a href="menu.php" class="nav-back">← Back to Categories</a>
            
            <a href="view_cart.php" class="view-cart-btn">🛒 View My Cart</a>
        </div>
        
        <?php
        $_SESSION['last_category_id'] = $category_id;

        $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
        $cat_stmt->bind_param("i", $category_id);
        $cat_stmt->execute();
        $res = $cat_stmt->get_result()->fetch_assoc();
        ?>
        
        <h1 style="border-bottom: 2px solid #cca3bb; padding-bottom: 10px;">
            Category: <?= htmlspecialchars($res['name'] ?? 'Products') ?>
        </h1>

        <div class="menu-grid">
            <?php
            $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND is_active = 1");
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $products = $stmt->get_result();

            if ($products->num_rows > 0):
                while($p = $products->fetch_assoc()): 
                    $final_price = $p['base_price'] * (1 + $p['vat']/100);
                    $has_stock = $p['stock'] > 0;
                ?>
                    <div class="product-card" style="<?= !$has_stock ? 'opacity: 0.7;' : '' ?>">
                        <div class="img-box">
                            <img src="assets/products/<?= $p['image_url'] ?: 'default.png' ?>" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="price-tag"><?= number_format($final_price, 2) ?> €</p>
                        
                        <?php if($has_stock): ?>
                            <a href="place_order.php?id=<?= $p['id'] ?>" class="order-btn">Add to Cart</a>
                            <div class="stock-info">In Stock: <?= $p['stock'] ?></div>
                        <?php else: ?>
                            <span class="order-btn out-of-stock-btn">Out of Stock</span>
                            <div class="stock-info" style="color: #d9534f; font-weight: bold;">Epuizat</div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
            else: ?>
                <p>No products in this category yet.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>