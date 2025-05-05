<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['utilisateur_id'])) {
    echo "<p>Vous devez être connecté pour modifier une recette.</p>";
    exit;
}

if (isset($_GET['id'])) {
    $recette_id = $_GET['id'];

    // Vérifier que l'utilisateur est le propriétaire de la recette
    $stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$recette_id, $_SESSION['utilisateur_id']]);
    $recette = $stmt->fetch();

    if (!$recette) {
        echo "<p>Recette introuvable ou vous n'êtes pas autorisé à la modifier.</p>";
        exit;
    }

    // Modifier la recette
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titre = trim($_POST['titre']);
        $ingredients = trim($_POST['ingredients']);
        $etapes = trim($_POST['etapes']);
        $categorie = $_POST['categorie'];

        // Gérer l'image
        $imagePath = $recette['image']; // Par défaut, on garde l'image existante

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Définir le répertoire où l'image sera sauvegardée
            $imageDir = 'uploads/';
            $imageName = basename($_FILES['image']['name']);
            $imagePath = $imageDir . $imageName;

            // Vérifier que le fichier est une image
            $imageType = mime_content_type($_FILES['image']['tmp_name']);
            if (strpos($imageType, 'image') === false) {
                echo "<p>Le fichier n'est pas une image valide.</p>";
                exit;
            }

            // Déplacer l'image téléchargée dans le répertoire
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                echo "<p>Une erreur est survenue lors du téléchargement de l'image.</p>";
                exit;
            }
        }

        // Vérifier que tous les champs sont remplis
        if (empty($titre) || empty($ingredients) || empty($etapes) || empty($categorie)) {
            echo "<p>Tous les champs sont obligatoires.</p>";
        } else {
            // Mettre à jour la recette avec l'image
            $stmt = $pdo->prepare("UPDATE recettes SET titre = ?, ingredients = ?, etapes = ?, categorie = ?, image = ? WHERE id = ?");
            $stmt->execute([$titre, $ingredients, $etapes, $categorie, $imagePath, $recette_id]);

            echo "<p>Recette modifiée avec succès !</p>";
            header("Location: recette.php?id=" . $recette_id);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une recette</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<h2>Modifier la recette</h2>

<!-- Formulaire pour modifier la recette -->
<form method="POST" enctype="multipart/form-data">
    <label for="titre">Titre :</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($recette['titre']) ?>" required><br><br>

    <label for="ingredients">Ingrédients :</label><br>
    <textarea name="ingredients" required><?= htmlspecialchars($recette['ingredients']) ?></textarea><br><br>

    <label for="etapes">Étapes :</label><br>
    <textarea name="etapes" required><?= htmlspecialchars($recette['etapes']) ?></textarea><br><br>

    <label for="categorie">Catégorie :</label><br>
    <select name="categorie" required>
        <option value="entrée" <?= $recette['categorie'] == 'entrée' ? 'selected' : '' ?>>Entrée</option>
        <option value="plat" <?= $recette['categorie'] == 'plat' ? 'selected' : '' ?>>Plat</option>
        <option value="dessert" <?= $recette['categorie'] == 'dessert' ? 'selected' : '' ?>>Dessert</option>
    </select><br><br>

    <!-- Champ pour télécharger une image -->
    <label for="image">Image :</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <?php if ($recette['image']) : ?>
        <p>Image actuelle :</p>
        <img src="<?= htmlspecialchars($recette['image']) ?>" alt="Image de la recette" width="200"><br><br>
    <?php endif; ?>

    <button type="submit">Modifier la recette</button>
</form>

</body>
</html>
