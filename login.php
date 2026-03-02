<?php
require_once 'includes/Applications.php';
require_once __DIR__ . '/includes/config.php';

$app = Applications::getInstance();
$app->init($dbConfig);

$error = $app->getAtributoPeticion('loginError');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Bistro FDI</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            padding: 30px; 
            background: #fdf2f4; 
            color: #333; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            min-height: 80vh;
        }
        
        .container { 
            width: 100%;
            max-width: 400px; 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); 
            text-align: center;
        }

        h1 { 
            color: #333; 
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #cca3bb;
            padding-bottom: 10px;
        }

        label { 
            display: block; 
            text-align: left; 
            font-weight: bold; 
            margin-top: 15px; 
            color: #555; 
        }

        input[type="text"], 
        input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            margin: 8px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            box-sizing: border-box; 
            font-size: 14px;
        }
        button[type="submit"] { 
            background: #cca3bb; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
            width: 100%; 
            margin-top: 25px; 
            font-size: 16px;
            transition: background 0.3s;
        }

        button[type="submit"]:hover { 
            background: #b089a0; 
        }

        .error-msg { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border-radius: 5px; 
            border: 1px solid #f5c6cb;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .footer-link { 
            margin-top: 20px; 
            font-size: 14px; 
            color: #777; 
        }

        .footer-link a { 
            color: #b089a0; 
            text-decoration: none; 
            font-weight: bold; 
        }

        .footer-link a:hover { 
            text-decoration: underline; 
        }

        .logo-icon {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <span class="logo-icon">🍴</span>
    <h1>Bistro FDI Authentication</h1>

    <?php if ($error): ?>
        <div class="error-msg">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="process_login.php">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter your username" required>
        
        <label>Password:</label>
        <input type="password" name="password" placeholder="••••••••" required>
        
        <button type="submit">Login</button>
    </form>

    <p class="footer-link">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

</body>
</html>