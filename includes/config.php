<?php

// __DIR__ represents current folder (includes)
require_once __DIR__ . '/Applications.php';
require_once __DIR__ . '/DTO/userDTO.php';
require_once __DIR__ . '/DAO/userDAO.php';
require_once __DIR__ . '/DTO/OrderDTO.php';
require_once __DIR__ . '/DAO/OrderDAO.php';

$dbConfig = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'bd' => 'bistro_fdi'
];

$app = Applications::getInstance();
$app->init($dbConfig);