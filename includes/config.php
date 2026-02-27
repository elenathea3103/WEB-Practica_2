<?php

// __DIR__ represents current folder (includes)
require_once __DIR__ . '/Applications.php';
<<<<<<< HEAD
require_once __DIR__ . '/DTO/userDTO.php';
require_once __DIR__ . '/DAO/userDAO.php';
=======
require_once __DIR__ . '/DTO/UserDTO.php';
require_once __DIR__ . '/DAO/UserDAO.php';
require_once __DIR__ . '/DTO/OrderDTO.php';
require_once __DIR__ . '/DAO/OrderDAO.php';
>>>>>>> 4344c96f4ffbeb0b8b3950e27b55a62c261e6bfe

$dbConfig = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'bd' => 'bistro_fdi'
];

$app = Applications::getInstance();
$app->init($dbConfig);