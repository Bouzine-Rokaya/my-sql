<?php
session_start();
require 'db.php';

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit;
}

$utilisateur_id = $_SESSION['utilisateur_id'];

if (isset($_GET['id'])) {
    $cours_id = intval($_GET['id']);

    // تحقق أولاً من أن هذه الجلسة تخص المستخدم
    $check = $pdo->prepare("SELECT * FROM revisions WHERE cours_id = ? AND utilisateur_id = ?");
    $check->execute([$cours_id, $utilisateur_id]);

    if ($check->rowCount() > 0) {
        // إذا الجلسة تخصه، احذفها
        $delete = $pdo->prepare("DELETE FROM revisions WHERE cours_id = ?");
        $delete->execute([$cours_id]);
    }
}

header("Location: revisions.php");
exit;
