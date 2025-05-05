<?php
require_once 'includes/db.php';
session_start();

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    if (empty($email) || empty($mot_de_passe)) {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
            $_SESSION['utilisateur_id'] = $utilisateur['id'];
            $_SESSION['utilisateur_nom'] = $utilisateur['nom'];
            header("Location: index.php");
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<!-- Ajoute la classe spécifique au body si ce n'est pas déjà fait -->
<body class="inscription-connexion-page page-inscription">

<div class="inscription-container">
    <div class="form-container">
        <h2>Connexion</h2>

        <?php if (!empty($erreur)): ?>
            <p style="color:red;"><?= $erreur ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email :</label>
            <input type="email" name="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe" required>

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
    </div>

    <!-- Image (optionnelle, comme dans la page d'inscription) -->
    <div class="image-container">
        <img src="images/register-login-background.png" alt="Connexion">
    </div>
</div>
</body>
