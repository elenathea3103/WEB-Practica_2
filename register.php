<?php
require_once 'includes/Applications.php';
$app = Applications::getInstance();
$app->init(['host' => 'vm019.db.swarm.test', 'user' => 'root', 'pass' => 'kw4BIhlwVSeRj3LNT_ks', 'bd' => 'bistro_fdi']);
$error = $app->getAtributoPeticion('registerError');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Bistro FDI</title>
    <style>
        /* standard visual style */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            padding: 30px; 
            background: #fdf2f4; 
            color: #333; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            min-height: 90vh;
        }
        
        .container { 
            width: 100%;
            max-width: 450px; 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); 
            text-align: center;
        }

        h2 { 
            color: #333; 
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #cca3bb;
            padding-bottom: 10px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        label { 
            display: block; 
            font-weight: bold; 
            margin-bottom: 5px; 
            color: #555; 
            font-size: 14px;
        }

        input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            box-sizing: border-box; 
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #cca3bb;
            outline: none;
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
            margin-top: 15px; 
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
    <span class="logo-icon">📝</span>
    <h2>Create an Account</h2>

    <?php if($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="process_register.php">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Choose a username" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@mail.com" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <div class="form-group" style="flex: 1;">
                <label>First Name</label>
                <input type="text" name="first_name" placeholder="John" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Last Name</label>
                <input type="text" name="last_name" placeholder="Doe" required>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <p class="footer-link">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>