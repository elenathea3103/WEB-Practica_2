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
</head>
<body>
    <h1>Bistro FDI Authentication</h1>

    <?php if ($error): ?>
        <p style="color: red;"><strong><?= htmlspecialchars($error) ?></strong></p>
    <?php endif; ?>

    <form method="POST" action="process_login.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>