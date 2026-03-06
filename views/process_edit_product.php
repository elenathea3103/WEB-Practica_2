<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['login'])) {
    if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'manager') {
        
        $id = (int)$_POST['id'];
        $name = $conn->real_escape_string($_POST['name']);
        $desc = $conn->real_escape_string($_POST['description']);
        $cat_id = (int)$_POST['category_id'];
        $price = (float)$_POST['base_price'];
        $vat = (int)$_POST['vat'];
        $stock = (int)$_POST['stock']; 
    $is_active = (int)$_POST['is_active'];
    $img = $conn->real_escape_string($_POST['image_url']);
      $sql = "UPDATE products SET 
            name = '$name', 
            category_id = $cat_id, 
            base_price = $price, 
            vat = $vat, 
            stock = $stock, 
            is_active = $is_active, 
            image_url = '$img' 
            WHERE id = $id";

        if ($conn->query($sql)) {
            header("Location: product_list.php?updated=1");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>