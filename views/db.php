<?php
// db.php
$host = "vm019.db.swarm.test";
$user = "root";
$pass = "kw4BIhlwVSeRj3LNT_ks";
$db = "bistro_fdi";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error connecting: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>