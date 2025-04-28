<?php
session_start();
require "config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $password = password_hash($_POST["mot_de_passe"],PASSWORD_DEFAULT);

    try{
        $sql = $conn->prepare("INSERT INTO utilisateurs (nom,email,mot_de_pass) 
        VALUES (?,?,?)");
        $sql->execute([$nom,$email,$password]);
        header("Location: connextion.php");
        exit();
    }catch(PDOException $e){
        echo "". $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>
<body>
    <form action="" method="post">
        nom: <br>
        <input type="text" name="nom"><br>
        email: <br>
        <input type="email" name="email"><br>
        mot de passe: <br>
        <input type="password" name="mot_de_passe"><br><br>
        <button>S'inscrire</button>
    </form>
</body>
</html>