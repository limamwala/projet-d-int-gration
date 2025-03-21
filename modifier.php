<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Modifier une Recette</h1>
    <?php
    $id = $_GET['id'];
    $sql = "SELECT * FROM recettes WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <form action="modifier_recette.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" value="<?php echo $row['titre']; ?>" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea><br>
        <label for="ingredients">Ingrédients:</label>
        <textarea id="ingredients" name="ingredients" required><?php echo $row['ingredients']; ?></textarea><br>
        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions" required><?php echo $row['instructions']; ?></textarea><br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>