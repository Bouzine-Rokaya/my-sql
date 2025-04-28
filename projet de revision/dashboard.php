<?php
session_start();
require 'config.php';
 
try{
    $sql = $conn->prepare('SELECT SUM(duree)/60 AS total_heures, AVG(note) AS moyen_note FROM revisions 
    WHERE utilisateur_id = ? AND date>= DATE_SUB(NOW(), INTERVAL 1 WEEK)');
    $sql->execute([$_SESSION['user_id']]);
    $stats_semaine = $sql->fetch(PDO::FETCH_ASSOC);

    $sql = $conn->prepare("SELECT COUNT(*) AS nombre FROM revisions 
    WHERE utilisateur_id = ? AND MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())");
    $sql->execute([$_SESSION['user_id']]);
    $stats_mois = $sql->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['nom']; ?></h1>
    
    <h2>Statistiques de la semaine :</h2>
    <p>Total d'heures : <?php echo round($stats_semaine['total_heures'], 2); ?> h</p>
    <p>Moyenne des notes : <?php echo round($stats_semaine['moyen_note'], 1); ?>/10</p>
    
    <h2>Ce mois :</h2>
    <p>Nombre de séances : <?php echo $stats_mois['nombre']; ?></p>
    
    <a href="ajouter_revision.php">Ajouter une révision</a> |
    <a href="revisions.php">Voir mes révisions</a>
</body>
</html>