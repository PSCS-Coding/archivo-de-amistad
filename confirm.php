<?php
require_once("connection.php");

$loginTest = "";
$redirect = false;

if(!empty($_POST['password'])){
    $loginTest = crypt($_POST['password'],'P9');
    $redirect = true;


} elseif(!empty($_COOKIE['login'])){
    $loginTest = $_COOKIE['login'];

}

$loginResult = $db_server->query("SELECT * FROM login");
$loginRow = $loginResult->fetch_assoc();

if($loginTest == $loginRow['password']){
    setcookie("login",$loginRow['password']);
    // echo "correct";
    if ($redirect){
        header('Location: index.php');
    }
} else {
    // echo "incorrect";
    header('Location: login.html?e=1'); 
}


?>