<?php
require_once("connection.php");

$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
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

$ipResult = $db_server->query("SELECT * FROM ip WHERE adress = '".$ip."' ");
if ($ipResult->num_rows != 1){
    echo "You are not whitelisted to user this server!";
    echo "<br>";
    echo "This incident will be recorded!";
    $stmt = $db_server->prepare("INSERT INTO logs (adress) VALUES (?)"); 
    $stmt->bind_param('s', $ip); 
    $stmt->execute(); 
    $stmt->close();
    header('Location: login.html?e=1');
}

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