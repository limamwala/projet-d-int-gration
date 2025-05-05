<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['utilisateur_id'])) {
    echo "<p>Vous devez être connecté pour supprimer une recette.</p>";
    exit;
}

if (isset($_GET['id'])) {
    $recette_id = $_GET['id'];

    // Vérifier que l'utilisateur est le propriétaire de la recette
    $stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$recette_id, $_SESSION['utilisateur_id']]);
    $recette = $stmt->fetch();

    if (!$recette) {
        echo "<p>Recette introuvable ou vous n'êtes pas autorisé à la supprimer.</p>";
        exit;
    }

    // Supprimer la recette
    $stmt = $pdo->prepare("DELETE FROM recettes WHERE id = ?");
    $stmt->execute([$recette_id]);

    echo "<p>Recette supprimée avec succès !</p>";
    header("Location: index.php");  // Redirection vers la page d'accueil
    exit;
}
?>
