<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$user_role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';
if ($user_role !== 'admin' && $user_role !== 'manager') {
    die("Unauthorized access.");
}


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: product_list.php?deleted=1");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
   
    header("Location: product_list.php");
    exit();
}