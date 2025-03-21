<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM recettes WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}
?>