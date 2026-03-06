<?php
require_once 'includes/config.php';
require_once 'includes/Applications.php';

$app = Applications::getInstance();
$app->init($dbConfig);
$conn = $app->getConexionBd();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bistro Menu</title>
    <link rel="stylesheet" href="<?= RUTA_CSS ?>style.css">
</head>

<body>
    <div class="container">

        <?php if ($category_id === 0): ?>
            <a href="order_type.php" class="nav-back">⬅️ Back to Order Method</a>
            <h1 style="text-align: center;">Select a Category</h1>

            <div class="menu-grid">
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($cat = $categories->fetch_assoc()): ?>
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
                    while ($p = $products->fetch_assoc()):
                        $final_price = $p['base_price'] * (1 + $p['vat'] / 100);
                        $has_stock = $p['stock'] > 0;
                        ?>
                        <div class="product-card" style="<?= !$has_stock ? 'opacity: 0.7;' : '' ?>">
                            <div class="img-box">
                                <img src="<?= RUTA_IMG ?><?= $p['image_url'] ?: 'default.png' ?>"
                                    style="width:100%; height:100%; object-fit:cover;">
                            </div>
                            <h3><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="price-tag"><?= number_format($final_price, 2) ?> €</p>

                            <?php if ($has_stock): ?>
                                <a href="place_order.php?id=<?= $p['id'] ?>" class="order-btn">Add to Cart</a>
                                <div class="stock-info">In Stock: <?= $p['stock'] ?></div>
                            <?php else: ?>
                                <span class="order-btn out-of-stock-btn">Out of Stock</span>
                                <div class="stock-info" style="color: #d9534f; font-weight: bold;">Out of stock</div>
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