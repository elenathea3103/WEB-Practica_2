<?php
require_once 'includes/config.php';
$app = Applications::getInstance();
$app->init($dbConfig);
$conn = $app->getConexionBd();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: menu.php");
    exit();
}

$today = date('Y-m-d');
$daily_query = "SELECT COUNT(*) as total FROM orders WHERE DATE(order_date) = '$today'";
$daily_res = $conn->query($daily_query);
$daily_row = $daily_res->fetch_assoc();
$daily_number = $daily_row['total'] + 1;

$total_price = 0;
foreach ($_SESSION['cart'] as $id => $quantity) {
    $p_res = $conn->query("SELECT base_price, vat FROM products WHERE id = $id");
    $p = $p_res->fetch_assoc();
    $price_with_vat = $p['base_price'] * (1 + $p['vat'] / 100);
    $total_price += $price_with_vat * $quantity;
}

$user_id = $_SESSION['user_id'] ?? 1;
$order_type = $_SESSION['current_order_type'] ?? 'Local';

$stmt = $conn->prepare("INSERT INTO orders (daily_number, user_id, type, total_price, status) VALUES (?, ?, ?, ?, 'New')");
$stmt->bind_param("iisd", $daily_number, $user_id, $order_type, $total_price);

if ($stmt->execute()) {
    $order_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $id => $quantity) {
        $p_res = $conn->query("SELECT base_price, vat FROM products WHERE id = $id");
        $p = $p_res->fetch_assoc();
        $price_at_purchase = $p['base_price'] * (1 + $p['vat'] / 100);

        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
        $item_stmt->bind_param("iiid", $order_id, $id, $quantity, $price_at_purchase);
        $item_stmt->execute();

        $conn->query("UPDATE products SET stock = stock - $quantity WHERE id = $id");
    }

    unset($_SESSION['cart']);
    unset($_SESSION['current_order_type']);

    header("Location: order_success.php?number=" . $daily_number);
    exit();
} else {
    echo "Error processing order: " . $conn->error;
}