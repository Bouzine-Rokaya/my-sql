<?php
$dsn="mysql:host=localhost;dbname=prodacts";
$user="root";
$pass= "";

try{
    $conn=new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $st = $conn->query("SELECT * FROM information");
    echo "<table border='1'>";
    echo "<tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";

    while($row = $st->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["firstname"]."</td>";
        echo "<td>".$row["lastname"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<br> good";
}catch(PDOException $e){
    echo $e->getMessage();
}
?>