<?php
$dsn = "mysql:host=localhost;dbname=suivi_revisions";
$user = "root";
$pass = "";

try{
    $conn = new PDO($dsn,$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo "connect data";
}catch(PDOException $e){
    echo $e->getMessage();
}