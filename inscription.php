<?php
require_once 'includes/db.php';
session_start();

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (
        strlen($mot_de_passe) < 6 ||
        !preg_match('/[A-Za-z]/', $mot_de_passe) ||    // au moins une lettre
        !preg_match('/[0-9]/', $mot_de_passe) ||       // au moins un chiffre
        !preg_match('/[^A-Za-z0-9]/', $mot_de_passe)   // au moins un symbole
    ) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères, incluant des lettres, des chiffres et des symboles.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $hash]);

            header("Location: connexion.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="inscription-connexion-page page-inscription">
    <?php include 'includes/header.php'; ?>

    <div class="inscription-container">
        <!-- Formulaire -->
        <div class="form-container">
            <h2>Créer un compte</h2>

            <?php if (!empty($erreur)): ?>
                <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>

            <form method="post">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" required>

                <label for="email">Email :</label>
                <input type="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" name="mot_de_passe" required
                       pattern="(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}"
                       title="Au moins 6 caractères avec des lettres, chiffres et symboles.">

                <button type="submit">S’inscrire</button>
            </form>
        </div>

        <!-- Image à droite -->
        <div class="image-container">
            <img src="images/register-login-background.png" alt="Image d'inscription">
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
