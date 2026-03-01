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
    <title>User Management (Manager Only)</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid black; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #ffffff; }
        
        .avatar-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
        
        .btn-delete {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .back-link { color: purple; text-decoration: underline; margin-bottom: 15px; display: inline-block; }
    </style>
</head>
<body>

    <h2>User Management (Manager Only)</h2>
    <a href="index.php" class="back-link">Back to Home</a>

    <?php if($msg) echo "<p style='color:blue;'>$msg</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Current Role</th>
                <th>Change Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td>
                    <img src="<?= $u->getAvatar() ? $u->getAvatar() : 'img/default-avatar.png' ?>" alt="Avatar" class="avatar-img">
                </td>
                
                <td><?= $u->getId() ?></td>
                <td><?= htmlspecialchars($u->getUsername()) ?></td>
                
                <td><?= htmlspecialchars($u->getFullName()) ?></td>
                
                <td><?= htmlspecialchars($u->getEmail()) ?></td>
                
                <td><?= ucfirst($u->getRole()) ?></td>
                
                <td>
                    <form action="process_admin_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $u->getId() ?>">
                        <select name="new_role">
                            <option value="client" <?= $u->getRole() == 'client' ? 'selected' : '' ?>>Client</option>
                            <option value="waiter" <?= $u->getRole() == 'waiter' ? 'selected' : '' ?>>Waiter</option>
                            <option value="cook" <?= $u->getRole() == 'cook' ? 'selected' : '' ?>>Cook</option>
                            <option value="manager" <?= $u->getRole() == 'manager' ? 'selected' : '' ?>>Manager</option>
                        </select>
                        <button type="submit" name="action" value="update_role">Update</button>
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

</body>
</html>