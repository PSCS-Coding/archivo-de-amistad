<?php
require_once("connection.php");

$loginResult = $db_server->query("SELECT * FROM login");
$loginRow = $loginResult->fetch_assoc();

if(crypt($_POST['password'], 'P9') == $loginRow['password']){
    header('Location: index.html?e=0'); 
} else {
    header('Location: login.html?e=1'); 
}

// $crypt = crypt('adenz8r3ry8nyinynzyi', 'P9');
?>