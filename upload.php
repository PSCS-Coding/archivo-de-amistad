<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once("connection.php"); 

$target_dir = "uploads/"; 
$target_file = $target_dir . basename($_POST['memeName'] . "." . explode(".", $_FILES["fileToUpload"]["name"])[1]); 
$uploadOk = 1; 
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$comments = $_POST['comments'];

print_r($_FILES);

if(empty($_FILES)){
    $url = $_GET['url'];
    $img = $target_dir . basename($_POST['memeName'] . "." . end(explode(".", $_POST['url'])));
    file_put_contents($img, file_get_contents($url));
}

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); 
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . "."; 
        $uploadOk = 1; 
    }else {
        echo "File is not an image."; 
        $uploadOk = 0; 
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists."; 
    $uploadOk = 0; 
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
    $uploadOk = 0; 
}

// make sure there is a comment
if (empty($_POST['comments'])){
    echo "you need a comment";
    header('Location: index.php?e=1');
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded."; 
    header('Location: index.php?e=1'); 
// if everything is ok, try to upload file
}else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "uploaded"; 
        echo $target_file;
        echo $comments;
        $stmt = $db_server->prepare("INSERT INTO memes (memeTitle,comments) VALUES (?,?)"); 
        $stmt->bind_param('ss', $target_file, $comments); 
        $stmt->execute(); 
        $stmt->close(); 

        header('Location: index.php?e=0'); 
    }else {
        echo "Sorry, there was an error uploading your file."; 
        header('Location: index.php?e=1'); 
    }
}?>