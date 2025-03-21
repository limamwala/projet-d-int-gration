<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="ajouter_recette.php" method="post">
    <fieldset>
    <center> <legend><h1>Ajouter une Recette</h1></legend></center>
    
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required><br>
        <label for="prix">prix:</label>
        <textarea id="prix" name="prix" required></textarea><br>
        <label for="ingredients">Ingrédients:</label>
        <textarea id="ingredients" name="ingredients" required></textarea><br>
        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions" required></textarea><br>
        <button type="submit">Ajouter</button>
        </fieldset>
    </form>
</body>
</html>