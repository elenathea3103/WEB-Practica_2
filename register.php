<?php
require_once 'includes/Applications.php';
$app = Applications::getInstance();
$app->init(['host' => 'localhost', 'user' => 'root', 'pass' => '', 'bd' => 'bistro_fdi']);
$error = $app->getAtributoPeticion('registerError');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Bistro FDI</title>
</head>
<body>
    <h2>Create an Account</h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="process_register.php">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="text" name="first_name" placeholder="First Name" required><br><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>