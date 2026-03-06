
<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/UserDAO.php';

$app = Applications::getInstance();
// initialize singleton with DB config
$app->init(['host' => 'vm019.db.swarm.test', 'user' => 'root', 'pass' => 'kw4BIhlwVSeRj3LNT_ks', 'bd' => 'bistro_fdi']);

$username = htmlspecialchars(trim(strip_tags($_POST['username'] ?? '')));
$password = htmlspecialchars(trim(strip_tags($_POST['password'] ?? '')));

$userDAO = new UserDAO();
$userDTO = $userDAO->findByUsername($username);

if ($userDTO && password_verify($password, $userDTO->getPassword())) {
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $userDTO->getId();
    $_SESSION['username'] = $userDTO->getUsername();
    $_SESSION['user_role'] = $userDTO->getRole();
    $_SESSION['avatar'] = $userDTO->getAvatar();
    
    header("Location: index.php");
} else {
    $app->putAtributoPeticion('loginError', "Invalid credentials. Please try again.");
    header("Location: login.php");
}
exit();