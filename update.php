<?php
require_once("connection.php");
print_r($_POST);

$memeId = array_keys($_POST)[1];
echo $memeId;

$stmt = $db_server->prepare("UPDATE memes SET tags=? WHERE memeId=?"); 
$stmt->bind_param('si', $_POST['tagsBox'], $memeId); 
$stmt->execute(); 
$stmt->close(); 

header("Location: index.php");

?>