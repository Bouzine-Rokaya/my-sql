<?php
$dsn = "mysql:host=localhost;dbname=prodacts";
$user = "root";
$pass = "";
$data = [];

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["select"])) {
        $email = $_POST["select"];
        $stmt = $conn->prepare("SELECT * FROM information WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $st = $conn->query("SELECT * FROM information");
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afficher les données</title>
</head>
<body>

    <form action="" method="post">
        <input type="text" name="select" placeholder="Entrer un email">
        <button type="submit">Select</button>
    </form>

    <br>

    <table border="1">
        <tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["firstname"] ?></td>
            <td><?= $row["lastname"] ?></td>
            <td><?= $row["email"] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
