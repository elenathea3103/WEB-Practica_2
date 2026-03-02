<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/UserDAO.php';

$app = Applications::getInstance();
$app->init(['host' => 'localhost', 'user' => 'root', 'pass' => '', 'bd' => 'bistro_fdi']);

if (!isset($_SESSION['login']) || $_SESSION['user_role'] !== 'manager') {
    header("Location: index.php");
    exit();
}

$userDAO = new UserDAO();
$users = $userDAO->findAll(); 

$msg = $app->getAtributoPeticion('adminMsg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Bistro FDI</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #fdf2f4; color: #333; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        h2 { color: #333; border-bottom: 2px solid #cca3bb; padding-bottom: 10px; margin-top: 0; }
        
        .nav-back {
            display: inline-flex; align-items: center; text-decoration: none; color: #fff; 
            background-color: #cca3bb; padding: 10px 20px; border-radius: 5px; 
            font-weight: bold; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        th { background: #cca3bb; color: white; padding: 12px; text-align: left; }
        td { border-bottom: 1px solid #eee; padding: 12px; vertical-align: middle; }
        tr:hover { background: #fff9fa; }

        .avatar-img { width: 45px; height: 45px; border-radius: 50%; border: 2px solid #f2dae5; object-fit: cover; }
        select { padding: 6px; border: 1px solid #ddd; border-radius: 4px; background: #fff; }
        
        .btn-update { 
            background: #cca3bb; color: white; border: none; padding: 6px 12px; 
            border-radius: 4px; cursor: pointer; font-weight: bold; 
        }
        .btn-update:hover { background: #b089a0; }

        .btn-delete {
            background-color: #d9534f; color: white; border: none; padding: 6px 12px; 
            border-radius: 4px; cursor: pointer; font-weight: bold;
        }
        .btn-delete:hover { background-color: #c9302c; }

        .msg-info { background: #d9edf7; color: #31708f; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #bcdff1; }
    </style>
</head>
<body>

<div style="max-width: 1100px; margin: auto;">
    <a href="index.php" class="nav-back">
        <span style="margin-right: 8px;">🏠</span> Back to Home
    </a>
</div>

<div class="container">
    <h2>User Management (Manager Only)</h2>

    <?php if($msg): ?>
        <div class="msg-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Change Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td>
                    <img src="<?= $u->getAvatar() ? $u->getAvatar() : 'assets/avatars/default.jpeg' ?>" alt="Avatar" class="avatar-img">
                </td>
                
                <td><strong>#<?= $u->getId() ?></strong></td>
                <td><?= htmlspecialchars($u->getUsername()) ?></td>
                <td><?= htmlspecialchars($u->getFullName()) ?></td>
                <td><small><?= htmlspecialchars($u->getEmail()) ?></small></td>
                
                <td>
                    <span style="padding: 3px 8px; background: #f2dae5; border-radius: 10px; font-size: 0.85em; font-weight: bold;">
                        <?= ucfirst($u->getRole()) ?>
                    </span>
                </td>
                
                <td>
                    <form action="process_admin_users.php" method="POST" style="display:inline-flex; gap: 5px;">
                        <input type="hidden" name="user_id" value="<?= $u->getId() ?>">
                        <select name="new_role">
                            <option value="client" <?= $u->getRole() == 'client' ? 'selected' : '' ?>>Client</option>
                            <option value="waiter" <?= $u->getRole() == 'waiter' ? 'selected' : '' ?>>Waiter</option>
                            <option value="cook" <?= $u->getRole() == 'cook' ? 'selected' : '' ?>>Cook</option>
                            <option value="manager" <?= $u->getRole() == 'manager' ? 'selected' : '' ?>>Manager</option>
                        </select>
                        <button type="submit" name="action" value="update_role" class="btn-update">Update</button>
                    </form>
                </td>
                
                <td>
                    <form action="process_admin_users.php" method="POST" onsubmit="return confirm('Delete this user?');">
                        <input type="hidden" name="user_id" value="<?= $u->getId() ?>">
                        <button type="submit" name="action" value="delete_user" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>