<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $prix = $_POST['prix'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $sql = "INSERT INTO recettes (titre, description, ingredients, instructions)
            VALUES ('$titre', '$prix', '$ingredients', '$instructions')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>