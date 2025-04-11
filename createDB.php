<?php
  $dsn = 'mysql:host=localhost'; 
  $user = 'root';  
  $pass = ''; 
  $message = '';

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
      $conn = new PDO($dsn, $user, $pass);  
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "CREATE DATABASE myname";
      $conn->exec($sql);
      $message = "<p style='color:green'>Created successfully</p>";
      
    }
    catch(PDOException $e){
      $message = "<p style='color:green'>".'failed: '.$e->getMessage()."</p>";
      
    } 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creat</title>
</head>
<body>
  <form method="post">
  <button type="submit">Creat database</button>
</form>
 <?php echo $message; ?>
</body>
</html>
