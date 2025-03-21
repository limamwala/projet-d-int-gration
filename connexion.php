<?php
require_once 'config.php'; // Assurez-vous que ce fichier contient vos informations de connexion à la base.
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mot_de_passe = trim($_POST['mot_de_passe']); // Mot de passe en clair

    try {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $utilisateur = $stmt->fetch();

        // Comparer le mot de passe directement (sans hashage)
        if ($utilisateur && $mot_de_passe === $utilisateur['mot_de_passe']) {
            $_SESSION['email'] = $utilisateur['email'];
            $_SESSION['prenom'] = $utilisateur['prenom'];

            // Rediriger vers une page sécurisée
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div style='color: red;'>Email ou mot de passe incorrect.</div>";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
