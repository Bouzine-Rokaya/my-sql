<?php
session_start();
require 'db.php';

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit;
}

$utilisateur_id = $_SESSION['utilisateur_id'];

// Récupérer les statistiques des 7 derniers jours
$stmt = $pdo->prepare("
    SELECT 
        SUM(duree) AS total_minutes, 
        AVG(note) AS moyenne_note 
    FROM revisions 
    WHERE utilisateur_id = ? 
      AND date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
");
$stmt->execute([$utilisateur_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$total_minutes = $stats['total_minutes'] ?? 0;
$moyenne_note = $stats['moyenne_note'] ? number_format($stats['moyenne_note'], 2) : '0.00';
$total_heures = round($total_minutes / 60, 2);
?>

<h2>Bienvenue dans votre Dashboard</h2>

<h3>Statistiques des 7 derniers jours</h3>
<ul>
    <li><strong>Total d'heures de révision :</strong> <?= $total_heures ?> h</li>
    <li><strong>Note moyenne de compréhension :</strong> <?= $moyenne_note ?>/10</li>
</ul>

<a href="ajouter_revision.php">➕ Ajouter une séance</a><br>
<a href="revisions.php">📋 Voir mes révisions</a><br>
<a href="logout.php">🚪 Déconnexion</a>

<?php

// Récupérer le nombre de séances du mois en cours
$stmt2 = $pdo->prepare("
    SELECT COUNT(*) AS total_seances 
    FROM revisions 
    WHERE utilisateur_id = ? 
      AND MONTH(date) = MONTH(CURDATE()) 
      AND YEAR(date) = YEAR(CURDATE())
");
$stmt2->execute([$utilisateur_id]);
$mois = $stmt2->fetch(PDO::FETCH_ASSOC);
$total_mois = $mois['total_seances'];
?>

<h3>Séances de ce mois</h3>
<ul>
    <li><strong>Nombre de séances réalisées :</strong> <?= $total_mois ?></li>
</ul>
