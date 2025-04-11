<?php
$dsn = "mysql:host=localhost;dbname=prodacts";
$user = "root";
$pass = "";
$data = [];

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $conn->query("SELECT * FROM information");
    $data = $st->fetchAll(PDO::FETCH_ASSOC);
    

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>select 1</title>
</head>
<body>


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
