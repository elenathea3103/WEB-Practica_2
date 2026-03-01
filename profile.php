<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/UserDAO.php';

$app = Applications::getInstance();
$app->init(['host' => 'localhost', 'user' => 'root', 'pass' => '', 'bd' => 'bistro_fdi']);

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$userDAO = new UserDAO();
$user = $userDAO->findById($_SESSION['user_id']);

$error = $app->getAtributoPeticion('profileError');
$success = $app->getAtributoPeticion('profileSuccess');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Bistro FDI</title>
</head>
<body>
    <h2>User Profile</h2>
    <p><a href="index.php">Back to Home</a></p>
    
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="process_profile.php" enctype="multipart/form-data">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required><br><br>

        <label>First Name:</label><br>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user->getFirstName()) ?>" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user->getLastName()) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required><br><br>

        <h3>Avatar</h3>
        <p>Current:<br>
        <img src="<?= $user->getAvatar() ?: 'assets/avatars/default.jpeg' ?>" width="100"></p>

        <label>Preset:</label><br>
        <input type="radio" name="avatar_option" value="assets/avatars/avatar1.jpeg"> Avatar 1
        <input type="radio" name="avatar_option" value="assets/avatars/avatar2.jpeg"> Avatar 2<br><br>

        <label>Custom:</label><br>
        <input type="file" name="custom_avatar" accept="image/*"><br><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>