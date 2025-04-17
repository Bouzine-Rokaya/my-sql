<?php
require 'db.php';
session_start();

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user["mot_de_pass"])) {
        $_SESSION["utilisateur_id"] = $user["utilisateur_id"];
        $_SESSION["nom"] = $user["nom"];
        header("Location: dashboard.php");
        exit;
    } else {
        $erreur = "Email ou mot de passe incorrects";
    }
}
?>

<form method="post">
    Email: <input type="email" name="email"><br>
    Mot de passe: <input type="password" name="mot_de_passe"><br>
    <button type="submit">Se connecter</button>
</form>

<?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
