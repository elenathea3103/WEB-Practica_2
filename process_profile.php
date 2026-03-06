<?php
require_once 'includes/Applications.php';
require_once 'includes/DAO/UserDAO.php';

$app = Applications::getInstance();
$app->init(['host' => 'vm019.db.swarm.test', 'user' => 'root', 'pass' => 'kw4BIhlwVSeRj3LNT_ks', 'bd' => 'bistro_fdi']);

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$userDAO = new UserDAO();
$userId = $_SESSION['user_id'];
$currentUser = $userDAO->findById($userId);

// inputs
$newUsername = htmlspecialchars(trim(strip_tags($_POST['username'])));
$firstName = htmlspecialchars(trim(strip_tags($_POST['first_name'])));
$lastName = htmlspecialchars(trim(strip_tags($_POST['last_name'])));
$email = htmlspecialchars(trim(strip_tags($_POST['email'])));

// check if username is unique
if ($userDAO->isUsernameTaken($newUsername, $userId)) {
    $app->putAtributoPeticion('profileError', "Username already taken!");
    header("Location: profile.php");
    exit();
}

// avatar
$avatar = $currentUser->getAvatar();
if (!empty($_POST['avatar_option'])) {
    $avatar = $_POST['avatar_option'];
}

if (isset($_FILES['custom_avatar']) && $_FILES['custom_avatar']['error'] == 0) {
    $targetDir = "uploads/avatars/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    
    $extension = pathinfo($_FILES["custom_avatar"]["name"], PATHINFO_EXTENSION);
    $fileName = time() . "_" . $userId . "." . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["custom_avatar"]["tmp_name"], $targetFile)) {
        $avatar = $targetFile;
    }
}

// update database (DTO)
$updatedUser = new UserDTO($newUsername, $currentUser->getPassword(), $currentUser->getRole(), $email, $firstName, $lastName, $avatar, $userId);

if ($userDAO->updateProfile($updatedUser)) {
    $_SESSION['username'] = $newUsername;
    $_SESSION['avatar'] = $avatar;
    $app->putAtributoPeticion('profileSuccess', "Profile updated successfully!");
} else {
    $app->putAtributoPeticion('profileError', "Database error during update.");
}

header("Location: profile.php");
exit();