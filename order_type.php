<?php
require_once 'includes/config.php';

$app = Applications::getInstance();
$app->init($dbConfig);

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Type - Bistro FDI</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 20px;
        }

        .option-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .option-box {
            border: 1px solid #080808;
            padding: 20px;
            text-align: center;
            width: 200px;
        }

        .btn-submit {
            margin-top: 20px;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #fbc7f5;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>Bistro FDI</h1>
    <p>Welcome, <strong><?= htmlspecialchars($username) ?></strong>!</p>
    <h2>How would you like to enjoy your meal today?</h2>

    <form method="POST" action="process_order_type.php">
        <div class="option-container">
            <div class="option-box">
                <h3>Dine In</h3>
                <p>Enjoy your food right here at Bistro FDI.</p>
                <input type="radio" name="order_type" value="Local" checked> Select
            </div>

            <div class="option-box">
                <h3>Takeaway</h3>
                <p>Pick up your order and eat on the go.</p>
                <input type="radio" name="order_type" value="Takeaway"> Select
            </div>
        </div>

        <button type="submit" class="btn-submit">Continue to Menu</button>
    </form>

    <p><a href="index.php">Back to Home</a> | <a href="logout.php">Logout</a></p>
</body>

</html>