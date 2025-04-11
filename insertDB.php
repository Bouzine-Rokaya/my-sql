<?php 
$dsn = 'mysql:host=localhost;dbname=prodacts';
$user = 'root';
$pass = '';
$message = '';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $firstname = $_POST["firstname"] ?? '';
    $lastname = $_POST["lastname"] ?? '';
    $email = $_POST["email"] ?? '';

    if(!empty($firstname) && !empty($lastname) && !empty($email)){
         try {
        $conn = new PDO($dsn, $user, $pass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO information (firstname, lastname, email)
        VALUES ('$firstname', '$lastname', '$email')";
        
        $conn->exec($sql);
        // $last_id = $conn->lastInsertId();

        $last_id = $conn->lastInsertId();
        echo "New record created successfully. Last inserted ID is: " . $last_id;
      
      } catch(PDOException $e) {
        $message =  $e->getMessage();
      }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert DB</title>
</head>
<body>
    <h1>PHP MySQL Insert Data</h1>
    <form method="post">
        <p>Firstname <input type="text" name="firstname"></p>
        <p>Lastname <input type="text" name="lastname"></p>
        <p>Email <input type="text" name="email"></p>
        <button>Insert</button>
    </form>
    <?php echo $message; ?>
</body>
</html>