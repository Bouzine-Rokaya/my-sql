<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("SELECT * FROM revisions WHERE cour_id = ? AND utilisateur_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    
    if ($stmt->rowCount() > 0) {
        $conn->prepare("DELETE FROM revisions WHERE cour_id = ?")->execute([$id]);
    }
    
    header("Location: revision.php");
    exit();
}