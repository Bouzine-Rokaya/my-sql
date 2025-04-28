<?php
session_start();
require "config.php";

if(!isset($_SESSION["user_id"])){
    header("Location: connextion.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $matiere = $_POST['matiere'];
    $duree = intval($_POST['duree']);
    $note = intval($_POST['note']);
    $date = $_POST['date'];

    if(empty($matiere) || empty($duree) || empty($note) || empty($date)){
        echo'tout les champs sont obligatoire';
    }elseif($note<0 || $note>10){
        echo 'note (0-10)';
    }else{
        try{
            $sql = $conn->prepare('INSERT INTO revisions(utilisateur_id,matière,duree,note,date)
            VALUES (?,?,?,?,?)');
            $sql->execute([$_SESSION["user_id"],$matiere, $duree, $note, $date]);
            header("Location:revision.php");
            exit();
        }catch(PDOException $e){
            echo "". $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter revision</title>
</head>
<body>
    <form action="" method="post">
        matiere: <br>
        <input type="text" name="matiere"><br>
        duree (min): <br>
        <input type="number" name="duree"><br>
        note (0-10): <br>
        <input type="number" name="note" min="0" max="10"><br>
        date: <br>
        <input type="date" name="date"><br><br>
        <button>ajoute</button>
    </form>
</body>
</html>