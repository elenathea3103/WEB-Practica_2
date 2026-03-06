
<?php
session_start();
require_once 'db.php';

$user_role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';
if (!isset($_SESSION['login']) || ($user_role !== 'admin' && $user_role !== 'manager')) {
    die("Unauthorized access.");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];


    $conn->query("UPDATE products SET category_id = NULL WHERE category_id = $id");

    $sql = "DELETE FROM categories WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: manage_categories.php?success=deleted");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}