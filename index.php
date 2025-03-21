<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Recettes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="">
    <fieldset>
  <legend> <h1>Liste des Recettes</h1></legend>
  
    <a href="ajouter.php">Ajouter une Recette</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>prix</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM recettes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['titre']}</td>
                        <td>{$row['description']}</td>
                        <td>
                            <a href='modifier.php?id={$row['id']}'>Modifier</a>
                            <a href='supprimer.php?id={$row['id']}'>Supprimer</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune recette trouvée</td></tr>";
        }
        ?>
    </table>
    </fieldset>
    </form>
</body>
</html>