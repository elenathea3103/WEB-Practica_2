<?php
require_once 'includes/config.php';
$app = Applications::getInstance();
$app->init($dbConfig);

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$avatar = $_SESSION['avatar'] ?: 'assets/avatars/default.jpeg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Method - Bistro FDI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
            background: #fdf2f4;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            border-bottom: 2px solid #cca3bb;
            padding-bottom: 10px;
        }

        .order-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .option-card {
            padding: 30px;
            border: 2px solid #f2dae5;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            background: #fef9fa;
        }

        .option-card:hover {
            border-color: #cca3bb;
            transform: translateY(-5px);
            background: #fff;
        }

        .option-card h3 {
            margin: 10px 0;
            color: #b089a0;
        }

        .option-card input {
            display: none;
        }


        .option-card.selected {
            border-color: #d147a3;
            background: #fff;
            box-shadow: 0 0 10px rgba(209, 71, 163, 0.2);
        }

        .btn-submit {
            margin-top: 40px;
            padding: 12px 40px;
            background: #cca3bb;
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #b089a0;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #999;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
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