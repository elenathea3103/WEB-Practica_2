<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/UserDAO.php';

$app = Applications::getInstance();
$app->init(['host' => 'localhost', 'user' => 'root', 'pass' => '', 'bd' => 'bistro_fdi']);

if (!isset($_SESSION['login']) || $_SESSION['user_role'] !== 'manager') {
    die("Access Denied");
}

$userDAO = new UserDAO();
$action = $_POST['action'] ?? '';
$targetId = $_POST['user_id'] ?? 0;

if ($action === 'update_role') {
    $newRole = $_POST['new_role'];
    $userDAO->updateRole($targetId, $newRole);
    $app->putAtributoPeticion('adminMsg', "Role updated for User ID: $targetId");
} 
else if ($action === 'delete_user') {
    if ($targetId == $_SESSION['user_id']) {
        $app->putAtributoPeticion('adminMsg', "You cannot delete yourself!");
    } else {
        $userDAO->delete($targetId);
        $app->putAtributoPeticion('adminMsg', "User $targetId deleted.");
    }
}

header("Location: admin_users.php");
exit();