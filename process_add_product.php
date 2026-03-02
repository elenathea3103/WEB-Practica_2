<?php
session_start();
require_once 'db.php';
require_once 'Product.php';


$user_role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';

if (!isset($_SESSION['login']) || ($user_role !== 'admin' && $user_role !== 'manager')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $product = new Product(
        $_POST['name'],
        $_POST['description'],
        $_POST['category_id'],
        $_POST['base_price'],
        $_POST['vat'],
        $_POST['stock'],    
        $_POST['is_active'], 
        $_POST['image_url']  
    );

    if ($product->save($conn)) {
        header("Location: product_list.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}