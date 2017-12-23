<?php
require_once("connection.php");

$loginResult = $db_server->query("SELECT * FROM login");
$loginRow = $loginResult->fetch_assoc();

if($_POST['password'] == $loginRow['password']){
    header('Location: index.html?e=0'); 
} else {
    header('Location: login.html?e=1'); 
}

// $crypt = crypt('adenz8r3ry8nyinynzyi', 'P9');
?>