<?php
session_start();
unset($_SESSION['cart']);
header("Location: view_cart.php");
exit();