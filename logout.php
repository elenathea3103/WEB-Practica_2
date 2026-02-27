<?php
require_once 'includes/Applications.php';
require_once 'includes/config.php';

$app = Applications::getInstance();
$app->init($dbConfig);

// unset all session variables
$_SESSION = [];

// destroy session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// destroy session and redirect
session_destroy();
header("Location: login.php");
exit();