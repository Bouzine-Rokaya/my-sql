<?php
session_start();
require 'db.php';

// تأكد أن المستخدم متصل
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit;
}

$utilisateur_id = $_SESSION["utilisateur_id"];

$stmt = $pdo->prepare("SELECT * FROM revisions WHERE utilisateur_id = ? ORDER BY date DESC");
$stmt->execute([$utilisateur_id]);
$revisions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mes séances de révision</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Matière</th>
        <th>Durée (min)</th>
        <th>Note</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php foreach ($revisions as $rev): ?>
    <tr>
        <td><?= htmlspecialchars($rev['matiere']) ?></td>
        <td><?= $rev['duree'] ?></td>
        <td><?= $rev['note'] ?></td>
        <td><?= $rev['date'] ?></td>
        <td>
            <a href="supprimer_revision.php?id=<?= $rev['cours_id'] ?>" onclick="return confirm('Supprimer cette séance ?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="dashboard.php">← Retour au Dashboard</a>
