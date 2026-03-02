<?php
session_start();
require_once 'db.php';

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    $check_query = "SELECT stock, name FROM products WHERE id = $product_id";
    $result = $conn->query($check_query);
    $product = $result->fetch_assoc();

    if ($product && $product['stock'] > 0) {
        
        $update_query = "UPDATE products SET stock = stock - 1 WHERE id = $product_id";
        
        if ($conn->query($update_query)) {
          
            header("Location: menu.php?ordered=" . urlencode($product['name']));
            exit();
        }
    } else {
        
        header("Location: menu.php?error=not_in_stock");
        exit();
    }
}
?>