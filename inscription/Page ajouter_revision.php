<?php
session_start();
require 'db.php';

// تأكد أن المستخدم متصل
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matiere = trim($_POST["matiere"]);
    $duree = intval($_POST["duree"]);
    $note = intval($_POST["note"]);
    $date = $_POST["date"];
    $utilisateur_id = $_SESSION["utilisateur_id"];

    if (empty($matiere) || empty($duree) || empty($note) || empty($date)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO revisions (matiere, duree, note, date, utilisateur_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$matiere, $duree, $note, $date, $utilisateur_id]);
        $message = "Révision ajoutée avec succès.";
    }
}
?>

<h2>Ajouter une séance de révision</h2>

<form method="post">
    Matière : <input type="text" name="matiere"><br>
    Durée (minutes) : <input type="number" name="duree"><br>
    Note de compréhension (0 à 10) : <input type="number" name="note" min="0" max="10"><br>
    Date : <input type="datetime-local" name="date"><br>
    <button type="submit">Ajouter</button>
</form>

<?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>
<a href="dashboard.php">Retour au dashboard</a>
