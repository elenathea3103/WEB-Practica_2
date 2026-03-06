<?php
require_once 'includes/config.php';
require_once 'includes/Applications.php';

$app = Applications::getInstance();
$app->init($dbConfig);

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$avatar = $_SESSION['avatar'] ?: RUTA_IMG . 'default.jpeg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Method - Bistro FDI</title>
    <link rel="stylesheet" href="<?= RUTA_CSS ?>style.css">
</head>

<body>

    <div class="container" style="max-width: 600px;">
        <h1>How would you like to order?</h1>

        <form action="process_order_type.php" method="POST">
            <div class="order-options">
                <label class="option-card" id="card-local">
                    <input type="radio" name="order_type" value="Local" checked onclick="selectCard('local')">
                    <span style="font-size: 40px;">🍽️</span>
                    <h3>Dine In</h3>
                    <small>Eat at our bistro</small>
                </label>

                <label class="option-card" id="card-takeaway">
                    <input type="radio" name="order_type" value="Takeaway" onclick="selectCard('takeaway')">
                    <span style="font-size: 40px;">🛍️</span>
                    <h3>Takeaway</h3>
                    <small>Pick up & go</small>
                </label>
            </div>

            <button type="submit" class="btn-submit">Continue to Menu ➔</button>
        </form>

        <a href="index.php" class="back-link">(Cancel) - Back to Home</a>
    </div>

    <script>
        function selectCard(type) {
            document.getElementById('card-local').classList.remove('selected');
            document.getElementById('card-takeaway').classList.remove('selected');
            document.getElementById('card-' + type).classList.add('selected');
        }

        selectCard('local');
    </script>

</body>

</html>