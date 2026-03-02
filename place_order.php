<?php
session_start();
require_once 'db.php';

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    $check_query = "SELECT stock, name, category_id FROM products WHERE id = $product_id";
    $result = $conn->query($check_query);
    $product = $result->fetch_assoc();

    if ($product && $product['stock'] > 0) {
        
        $update_query = "UPDATE products SET stock = stock - 1 WHERE id = $product_id";
        
        if ($conn->query($update_query)) {
            header("Location: menu.php?id=" . $product['category_id'] . "&ordered=" . urlencode($product['name']));
            exit();
        }
    } else {
        $cat_param = isset($product['category_id']) ? "id=" . $product['category_id'] . "&" : "";
        header("Location: menu.php?" . $cat_param . "error=not_in_stock");
        exit();
    }
}
?>