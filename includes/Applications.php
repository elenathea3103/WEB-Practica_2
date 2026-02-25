<?php

class Applications
{
    private static $instance;
    private $dbConnectionData;
    private $isInitialized = false;
    private $conn;
    private $requestAttributes;

    const REQUEST_ATTRIBUTES_SESSION_KEY = 'attsPeticion';

    public static function getInstance() 
    {
        if (!self::$instance instanceof self) 
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function init($dbConnectionData)
    {
        if (!$this->isInitialized) 
        {
            $this->dbConnectionData = $dbConnectionData;
            $this->isInitialized = true;
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $this->requestAttributes = $_SESSION[self::REQUEST_ATTRIBUTES_SESSION_KEY] ?? [];
            unset($_SESSION[self::REQUEST_ATTRIBUTES_SESSION_KEY]);
        }
    }

    public function getConexionBd()
    {
        if (!$this->conn) 
        {
            $host = $this->dbConnectionData['host'];
            $user = $this->dbConnectionData['user'];
            $pass = $this->dbConnectionData['pass'];
            $db   = $this->dbConnectionData['bd'];
            
            $this->conn = new mysqli($host, $user, $pass, $db);
            if ($this->conn->connect_errno) {
                die("DB Error: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8mb4");
        }
        return $this->conn;
    }

    public function putAtributoPeticion($key, $value)
    {
        $_SESSION[self::REQUEST_ATTRIBUTES_SESSION_KEY][$key] = $value;
    }

    public function getAtributoPeticion($key)
    {
        return $this->requestAttributes[$key] ?? null;
    }
}