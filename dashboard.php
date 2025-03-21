<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: connexion.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom']); ?> !</h2>
    <a href="deconnection.php" style="color: red; text-decoration: none; font-weight: bold;">Déconnexion</a>
</body>
</html>
