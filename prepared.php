
<?php
$dsn = "mysql:host=localhost;dbname=prodacts";
$user = "root";
$pass = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];

    $firstname1 = $_POST["firstname1"];
    $lastname1 = $_POST["lastname1"];
    $email1 = $_POST["email1"];

    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->beginTransaction();

        $stmt1 = $conn->prepare("INSERT INTO information (firstname, lastname, email)
        VALUES (:firstname, :lastname, :email)");
        $stmt1->bindParam(':firstname', $firstname);
        $stmt1->bindParam(':lastname',$lastname);
        $stmt1->bindParam(':email', var: $email);
        $stmt1->execute(); 

        $stmt2 = $conn->prepare("INSERT INTO information (firstname, lastname, email)
        VALUES (:firstname, :lastname, :email)");
        $stmt2->bindParam(':firstname', $firstname1);
        $stmt2->bindParam(':lastname', $lastname1);
        $stmt2->bindParam(':email', $email1);
        $stmt2->execute(); 

        $conn->commit();

        $message = "<p>New records created successfully!</p>";

    } catch (PDOException $e) {
        $conn->rollBack();
        $message = "<p >Error: " . $e->getMessage() . "</p>";
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
    

    <p>First Name 1<input type="text" name="firstname1"></p>
    <p>Last Name 1<input type="text" name="lastname1"></p>
    <p>Email <input type="text" name="email1"></p>
    
    <button>Insert prepared statements</button>
</form>
<?php echo $message ?>
</body>
</html>

