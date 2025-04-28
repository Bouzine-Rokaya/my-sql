<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["mot_de_passe"];

    if(empty($email) || empty($password)) {
        echo "tout les champs sont obligatoire";
    }else{
        try{
        $st = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $st->execute([$email]);
        $utilisateur = $st->fetch(PDO::FETCH_ASSOC);
        if($utilisateur && password_verify($password, $utilisateur["mot_de_pass"])) {
                $_SESSION["user_id"]=$utilisateur["utilisateur_id"];
                $_SESSION["nom"]=$utilisateur["nom"];
                header("Location: dashboard.php");
                exit();
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
</head>
<body>
    <form action="" method="post">
        email: <br>
        <input type="email" name="email"><br>
        mot de passe: <br>
        <input type="password" name="mot_de_passe"><br><br>

        <button>Se connecter</button>

    </form>
</body>
</html>