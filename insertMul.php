<?php
$dsn = 'mysql:host=localhost;dbname=doctors';
$user = 'root';
$pass = "";
$message  = "";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];

    $firstname1 = $_POST["firstname1"];
    $lastname1 = $_POST["lastname1"];
    $email1 = $_POST["email1"];
    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
       
        $conn->exec("INSERT INTO formation (firstname, lastname, email)
        VALUES ('$firstname', '$lastname', '$email'),('$firstname1', '$lastname1', '$email1')");
        // $conn->exec("INSERT INTO formation (firstname, lastname, email)
        // VALUES ('$firstname1', '$lastname1', '$email1')");
    
        $message = "GOOD!";
    } catch (PDOException $e) {
        $message = "ERROR: " . $e->getMessage();
    }
    
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
<form method="post">
    <p>First Name <input type="text" name="firstname"></p>
    <p>Last Name <input type="text" name="lastname"></p>
    <p>Email <input type="text" name="email"></p>
    

    <p>First Name <input type="text" name="firstname1"></p>
    <p>Last Name <input type="text" name="lastname1"></p>
    <p>Email <input type="text" name="email1"></p>
    
    <button>insert</button>
</form>
<?php echo $message ?>
</body>
</html>