<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo "<p>Vous devez être connecté pour laisser un commentaire.</p>";
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = trim($_POST['commentaire']);
    $note = (int)$_POST['note'];
    $recette_id = (int)$_POST['recette_id'];
    $utilisateur_id = $_SESSION['utilisateur_id'];

    if ($commentaire !== '' && $note >= 1 && $note <= 5) {
        // Ajouter le commentaire dans la base de données
        $stmt = $pdo->prepare("INSERT INTO commentaires (id_recette, id_utilisateur, commentaire, note, date_post)
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$recette_id, $utilisateur_id, $commentaire, $note]);

        header("Location: recette.php?id=$recette_id");
        exit;
    } else {
        echo "Commentaire ou note invalide.";
    }
}

// Vérifier si l'ID de la recette est présent dans l'URL
if (isset($_GET['id'])) {
    $recette_id = $_GET['id'];

    // Récupérer les détails de la recette
    $stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ?");
    $stmt->execute([$recette_id]);
    $recette = $stmt->fetch();

    if (!$recette) {
        echo "<p>Recette non trouvée.</p>";
        include 'includes/footer.php';
        exit;
    }
} else {
    echo "<p>Aucune recette sélectionnée.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($recette['titre']) ?> - Commentaire</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="recette-container">
    <h2><?= htmlspecialchars($recette['titre']) ?></h2>

    <?php if (!empty($recette['image']) && file_exists('uploads/' . $recette['image'])): ?>
        <div class="image-recette">
            <img src="uploads/<?= htmlspecialchars($recette['image']) ?>" alt="Image de la recette" style="max-width: 100%; height: auto;">
        </div>
    <?php else: ?>
        <p>Aucune image disponible pour cette recette.</p>
    <?php endif; ?>

    <h3>Laisser un commentaire :</h3>
    <form method="post" action="commentaire.php?id=<?= $recette['id'] ?>">
        <textarea name="commentaire" required placeholder="Votre commentaire"></textarea><br>
        <label for="note">Note (1 à 5) :</label>
        <input type="number" name="note" min="1" max="5" required><br>
        <input type="hidden" name="recette_id" value="<?= $recette['id'] ?>">
        <button type="submit">Ajouter commentaire</button>
    </form>
</div>

</body>
</html>
