<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';
?>

<head>
  <meta charset="UTF-8">
  <title>Recettes de Cuisine</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="index-page">
<div class="overlay">
    <h1>Bienvenue sur Recettes en ligne</h1>
    <p>Explorez des recettes délicieuses et partagez les vôtres !</p>
</div>

<?php if (isset($_SESSION['utilisateur_id'])): ?>
  <h2>Bienvenue sur vos recettes !</h2>

  <?php
  // Récupérer toutes les recettes
  $recettes = $pdo->query("SELECT * FROM recettes ORDER BY id DESC")->fetchAll();
  ?>

  <?php if (count($recettes) > 0): ?>
    <div class="recettes">
      <?php foreach ($recettes as $recette): ?>
        <div class="recette" style="border:1px solid #ccc; padding:15px; margin:10px 0; border-radius:10px;">
          <h3><a href="recette.php?id=<?= $recette['id'] ?>"><?= htmlspecialchars($recette['titre']) ?></a></h3>
          <p><strong>Catégorie :</strong> <?= htmlspecialchars($recette['categorie']) ?></p>

          <?php if (!empty($recette['image'])): ?>
            <div class="image-recette">
              <img src="images/<?= htmlspecialchars($recette['image']) ?>" alt="Image de la recette" style="max-width: 300px; height: auto; border-radius: 8px; margin: 10px 0;">
            </div>
          <?php endif; ?>

          <p><strong>Ingrédients :</strong><br> <?= nl2br(htmlspecialchars($recette['ingredients'])) ?></p>
          <p><strong>Étapes :</strong><br> <?= nl2br(htmlspecialchars($recette['etapes'])) ?></p>

          <p>
            <a href="modifier.php?id=<?= $recette['id'] ?>">Modifier</a> |
            <a href="supprimer.php?id=<?= $recette['id'] ?>">Supprimer</a>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Aucune recette disponible pour le moment.</p>
  <?php endif; ?>

  <a href="ajouter.php">Ajouter une nouvelle recette</a>

<?php else: ?>
  <p>⚠️ Vous devez être connecté pour voir les recettes.</p>
  <a href="connexion.php">Se connecter</a> | <a href="inscription.php">Créer un compte</a>
<?php endif; ?>
</body>
