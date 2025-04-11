<?php
$dsn="mysql:host=localhost;dbname=prodacts";
$user="root";
$pass="";
$data=[];

// try{
//     $conn = new PDO($dsn,$user,$pass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     if($_SERVER['REQUEST_METHOD']=="POST" && !empty( $_POST["select"] )){
//         $email = $_POST["select"];
//         $st =$conn->prepare("SELECT * FROM information WHERE email=:email");
//         $st->bindParam(":email", $email);
//         $st->execute(); 
//         $data= $st->fetchAll(PDO::FETCH_ASSOC);
       
//     }else{
//          $st =$conn->query("SELECT * FROM information");
//         $data=$st->fetchAll(PDO::FETCH_ASSOC);
//     }
// }catch(PDOException $e){
//     echo $e->getMessage();
// } 

try{
    $conn = new PDO($dsn,$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($_SERVER['REQUEST_METHOD']=="POST" ){
        // $email = $_POST["select"];
        $st =$conn->prepare("SELECT * FROM information ORDER BY lastname");
        // $st->bindParam(":email", $email);
        $st->execute(); 
        $data= $st->fetchAll(PDO::FETCH_ASSOC);
       
    }else{
         $st =$conn->query("SELECT * FROM information");
        $data=$st->fetchAll(PDO::FETCH_ASSOC);
    }
}catch(PDOException $e){
    echo $e->getMessage();
} 

// try{
//     $conn = new PDO($dsn,$user,$pass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $st =$conn->query("SELECT * FROM information");
//     $data=$st->fetchAll(PDO::FETCH_ASSOC);
// }catch(PDOException $e){
//     echo $e->getMessage();
// } 
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
            <tr><th>Id</th><th>first name</th><th>last name</th><th>email</th></tr>
                <?php foreach($data as $row): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= $row["firstname"] ?></td>
                <td><?= $row["lastname"] ?></td>
                <td><?= $row["email"] ?></td>
            </tr>
                <?php endforeach; ?>
        </table>
        <!-- <input type="text" name="select"> -->
        <button>select</button>
    </form>
</body>
</html>