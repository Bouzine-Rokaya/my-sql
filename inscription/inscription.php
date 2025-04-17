<?php
require 'db.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_pass) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$nom, $email, $mot_de_passe_hash]);
            header("Location: connexion.php");
            exit;
        } catch (PDOException $e) {
            $erreur = "Email déjà utilisé.";
        }
    }
}
?>

<form method="post">
    Nom: <input type="text" name="nom"><br>
    Email: <input type="email" name="email"><br>
    Mot de passe: <input type="password" name="mot_de_passe"><br>
    <button type="submit">S'inscrire</button>
</form>

<?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
