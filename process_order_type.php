<?php
require_once 'includes/config.php';
$app = Applications::getInstance();
$app->init($dbConfig);

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['current_order_type'] = $_POST['order_type'];
    header('Location: menu.php');
    exit();
}