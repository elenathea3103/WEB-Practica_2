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
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #fdf2f4; color: #333; }
        .container { max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        h2 { color: #333; border-bottom: 2px solid #cca3bb; padding-bottom: 10px; margin-top: 0; }
        h3 { color: #b089a0; margin-top: 20px; border-bottom: 1px solid #f2dae5; padding-bottom: 5px; }
        
        label { font-weight: bold; display: block; margin-top: 15px; color: #555; }
        input[type="text"], input[type="email"], input[type="file"] { 
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; 
        }
        
        button[type="submit"] { 
            background: #cca3bb; color: white; border: none; padding: 12px 25px; border-radius: 5px; 
            cursor: pointer; font-weight: bold; width: 100%; margin-top: 20px; font-size: 16px;
            transition: background 0.3s;
        }
        button[type="submit"]:hover { background: #b089a0; }

        .msg { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .avatar-preview { border-radius: 50%; border: 3px solid #cca3bb; object-fit: cover; margin-bottom: 10px; }
        .avatar-options { background: #fef9fa; padding: 15px; border-radius: 8px; border: 1px solid #f2dae5; margin-top: 10px; }
        
        .nav-back {
            display: inline-flex; align-items: center; text-decoration: none; color: #fff; 
            background-color: #cca3bb; padding: 10px 20px; border-radius: 5px; 
            font-weight: bold; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div style="max-width: 600px; margin: auto;">
    <a href="index.php" class="nav-back">
        <span style="margin-right: 8px;">🏠</span> Back to Home
    </a>
</div>

<div class="container">
    <h2>User Profile</h2>
    
    <?php if($error): ?>
        <div class="msg error"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="process_profile.php" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user->getFirstName()) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user->getLastName()) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>

        <h3>Avatar</h3>
        <div style="text-align: center; margin-bottom: 15px;">
            <p>Current Avatar:</p>
            <img src="<?= $user->getAvatar() ?: 'assets/avatars/default.jpeg' ?>" width="100" height="100" class="avatar-preview">
        </div>

        <div class="avatar-options">
            <label>Choose a Preset:</label>
            <div style="margin: 10px 0;">
                <input type="radio" name="avatar_option" value="assets/avatars/avatar1.jpeg"> Avatar 1
                <input type="radio" name="avatar_option" value="assets/avatars/avatar2.jpeg" style="margin-left: 20px;"> Avatar 2
            </div>

            <label>Or Upload Custom:</label>
            <input type="file" name="custom_avatar" accept="image/*">
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>