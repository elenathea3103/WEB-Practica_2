<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Success - Bistro FDI</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            padding: 50px;
            background: #fdf2f4;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #cca3bb;
        }

        .number {
            font-size: 3em;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Order Placed!</h1>
        <p>Your order number for today is:</p>
        <div class="number">#
            <?= htmlspecialchars($_GET['number'] ?? '0') ?>
        </div>
        <p>Please wait for your number to appear on the screen.</p>
        <a href="index.php" style="color: #cca3bb; font-weight: bold;">Back to Home</a>
    </div>
</body>

</html>