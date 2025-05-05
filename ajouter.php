<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['utilisateur_id'])) {
    echo "<p>Vous devez être connecté pour ajouter une recette.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = trim($_POST['titre']);
    $ingredients = trim($_POST['ingredients']);
    $etapes = trim($_POST['etapes']);
    $categorie = $_POST['categorie'];

    $image_nom = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_nom = basename($_FILES['image']['name']);
        $chemin_cible = "images/" . $image_nom;  

      
        if (!is_dir("images")) {
            mkdir("images", 0777, true);  
        }

        if (!move_uploaded_file($image_tmp, $chemin_cible)) {
            echo "<p>Erreur lors de l'upload de l'image.</p>";
            exit;
        }
    }

    if (empty($titre) || empty($ingredients) || empty($etapes) || empty($categorie)) {
        echo "<p>Tous les champs sont obligatoires.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO recettes (titre, ingredients, etapes, categorie, image, id_utilisateur)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $ingredients, $etapes, $categorie, $image_nom, $_SESSION['utilisateur_id']]);

        echo "<p>Recette ajoutée avec succès !</p>";
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une recette</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<h2>Ajouter une nouvelle recette</h2>

<form method="POST" enctype="multipart/form-data">
    <label for="titre">Titre :</label><br>
    <input type="text" name="titre" required><br><br>

    <label for="ingredients">Ingrédients :</label><br>
    <textarea name="ingredients" required></textarea><br><br>

    <label for="etapes">Étapes :</label><br>
    <textarea name="etapes" required></textarea><br><br>

    <label for="categorie">Catégorie :</label><br>
    <select name="categorie" required>
        <option value="entrée">Entrée</option>
        <option value="plat">Plat</option>
        <option value="dessert">Dessert</option>
    </select><br><br>

    <label for="image">Image de la recette :</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Ajouter la recette</button>
</form>

</body>
</html>
