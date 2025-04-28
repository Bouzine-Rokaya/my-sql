<?php
session_start();
require 'config.php';

if(!isset($_SESSION['user_id'])){
    header('Location:connextion.php');
    exit();
}

try{
    $sql = $conn->prepare('SELECT*FROM revisions WHERE utilisateur_id=? ORDER BY date DESC');
    $sql->execute([$_SESSION['user_id']]);
    $revision = $sql->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo''. $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>revision</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>matiere</th>
            <th>duree</th>
            <th>note</th>
            <th>date</th>
            <th>supprimer</th>
        </tr>
        <?php foreach($revision as $data): ?>
            <tr>
                <td><?= $data['matière']?></td>
                <td><?= $data['duree']?></td>
                <td><?= $data['note']?></td>
                <td><?= $data['date']?></td>
                <td>
                    <form action="supprimer_revision.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $data['cour_id']?>">
                        <button>supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>