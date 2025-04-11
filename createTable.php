<?php
$dsn = 'mysql:host=localhost;dbname=prodacts';
$user = 'root';
$pass = '';
$message = "";

if($_SERVER['REQUEST_METHOD'] =="POST"){
  $tableName = $_POST['table_name'] ?? '';
  $col1 = $_POST["col1"] ?? '';
  $col2 = $_POST["col2"] ?? '';
  $col3 = $_POST["col3"] ?? '';
  $col4 = $_POST["col4"] ?? '';
  $col5 = $_POST["col5"] ?? '';

  if(!empty($tableName)&& !empty($col1)&& !empty($col2)&& !empty($col3)&& !empty($col4)&& !empty($col5)){
    try{
      $conn = new PDO($dsn,$user,$pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "CREATE TABLE `$tableName`(
      id INT AUTO_INCREMENT PRIMARY KEY,
      $col1 VARCHAR(255),
      $col2 VARCHAR(255),
      $col3 VARCHAR(255),
      $col4 VARCHAR(255),
      $col5 VARCHAR(255)
      )";

      $conn->exec($sql);
      $message = "<p style='color:green'>✅ Table '$tableName' created successfully.</p>";

    } catch(PDOException $e){
      $message = "<p>".$e->getMessage()."</p>";
    }
  }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>create table</title>
</head>
<body>
  <h1>PHP Create a MySQL Database</h1>
  <form method="post">
    <p>Table name <input type="text" name="table_name"></p>
    <p>column1 <input type="text" name="col1"></p>
    <p>column2 <input type="text" name="col2"></p>
    <p>column3 <input type="text" name="col3"></p>
    <p>column4 <input type="text" name="col4"></p>
    <p>column5 <input type="text" name="col5"></p>
    <button>Creat Table</button>
  </form>
  <?php echo $message; ?>
</body>
</html>