<?php
    $dsn="mysql:host=localhost;dbname=doctors";
    $user="root";
    $pass="";
    $message="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        
        if(!empty($firstname) && !empty($lastname)&& !empty($email)){
    try{
        $conn=new PDO($dsn,$user,$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql0="CREATE DATABASE IF NOT EXISTS doctors;";
        $conn->exec($sql0);

        $sql1 = "CREATE TABLE IF NOT EXISTS `formation`(
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255),
        lastname VARCHAR(255),
        email VARCHAR(255))";
        $conn->exec($sql1);

        $sql="INSERT INTO formation(firstname,lastname,email)
        VALUES ('$firstname','$lastname','$email')";
        $conn->exec($sql);

        $last_id = $conn->lastInsertId();
       
        $message = "New record created successfully. Last inserted ID is: " . $last_id;

    }catch(PDOException $e){
        $message=$e->getMessage();
    }}}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insertDB 1</title>
</head>
<body>
    
<form method="post">
    <p>First Name <input type="text" name="firstname"></p>
    <p>Last Name <input type="text" name="lastname"></p>
    <p>Email <input type="text" name="email"></p>
    

    <button>insert</button>
</form>
<?php echo $message ?>
</body>
</html>