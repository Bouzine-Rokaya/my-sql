<?php
$dsn='mysql:host=localhost;dbname=prodacts';
$user='root';
$pass= '';
$result=[];
$edit = false;
$editData=[];

try{
    $conn=new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_GET["delete"])){
           
        $id = $_GET["delete"];
        $stmt = $conn->prepare("DELETE FROM information WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

    }
    if (isset($_GET["edit"])) {
        $edit = true;
        $id = $_GET["edit"];
        $stmt = $conn->prepare("SELECT * FROM information WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $editData = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if(isset($_POST['modifier'])){
        $id=$_POST["id"];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $stmt = $conn->prepare('UPDATE information SET firstname=:firstname,lastname=:lastname,email=:email WHERE id = :id');
        $stmt->execute([
            ':id'=> $id,
            ':firstname'=> $firstname,
            ':lastname'=> $lastname,
            'email'=> $email
        ]);
    }

    if(isset($_POST['insert'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $st = "INSERT INTO information(firstname,lastname,email) 
        VALUES ('$firstname','$lastname','$email')";
        $conn->exec($st);
    }

    $st=$conn->prepare('SELECT *FROM information');
    $st->execute();
    $result=$st->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo ''.$e->getMessage().'';
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <table border="1">
        <tr>
            <th>Id</th>
            <th>firstname</th>
            <th>lastname</th>
            <th>email</th>
        </tr>
        <?php foreach($result as $row): ?>
        <tr>
            <td><?=$row["id"]?></td>
            <td><?=$row["firstname"]?></td>
            <td><?=$row["lastname"]?></td>
            <td><?=$row["email"]?></td>
            <td>
                <a href="?delete=<?= $row["id"]?>">supprimer</a>
                <a href="?edit=<?= $row["id"]?>">modifier</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php if($edit):?>
        <input type="hidden" name="id" value="<?=$editData["id"]?>">
        firstname:<input type="text" name="firstname" value="<?=$editData["firstname"]?>"><br>
        lastname:<input type="text" name="lastname" value="<?=$editData["lastname"]?>"><br>
        email:<input type="text" name="email" value="<?=$editData["email"]?>"><br>
        <button name="modifier">modifier</button>
    <?php else:?>
        firstname:<input type="text" name="firstname" ><br>
        lastname:<input type="text" name="lastname" ><br>
        email:<input type="text" name="email" ><br>    
        <button name="insert">insert</button>
    <?php endif;?>
    </form>
</body>
</html>