<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/userDAO.php';

$app = Applications::getInstance();
$app->init(['host' => 'vm019.db.swarm.test', 'user' => 'root', 'pass' => 'kw4BIhlwVSeRj3LNT_ks', 'bd' => 'bistro_fdi']);

$username = htmlspecialchars(trim(strip_tags($_POST['username'])));
$email = htmlspecialchars(trim(strip_tags($_POST['email'])));
$firstName = htmlspecialchars(trim(strip_tags($_POST['first_name'])));
$lastName = htmlspecialchars(trim(strip_tags($_POST['last_name'])));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

$userDAO = new UserDAO();

// check if username exists
if ($userDAO->isUsernameTaken($username, 0)) {
    $app->putAtributoPeticion('registerError', "Username already exists!");
    header("Location: register.php");
    exit();
}

// create DTO and save (default role 'client', default avatar)
$newUser = new UserDTO($username, $password, 'client', $email, $firstName, $lastName, 'assets/avatars/default.jpeg');

if ($userDAO->registerUser($newUser)) {
    header("Location: login.php?registered=success");
} else {
    $app->putAtributoPeticion('registerError', "Error creating account.");
    header("Location: register.php");
}
exit();