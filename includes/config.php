<?php

// __DIR__ represents current folder (includes)
require_once __DIR__ . '/Applications.php';
require_once __DIR__ . '/DTO/userDTO.php';
require_once __DIR__ . '/DAO/userDAO.php';
require_once __DIR__ . '/DTO/OrderDTO.php';
require_once __DIR__ . '/DAO/OrderDAO.php';
require_once __DIR__ . '/DTO/OrderItemDTO.php';

$dbConfig = [
    'host' => 'vm019.db.swarm.test',
    'user' => 'root',
    'pass' => 'kw4BIhlwVSeRj3LNT_ks',
    'bd' => 'bistro_fdi'
];

$app = Applications::getInstance();
$app->init($dbConfig);

define('RUTA_APP', '/');
define('RUTA_CSS', RUTA_APP . 'assets/css/');
define('RUTA_IMG', RUTA_APP . 'assets/img/');
define('RUTA_JS', RUTA_APP . 'assets/js/');

define('RUTA_VIEWS', RUTA_APP . 'views/');