<?php
$host = 'localhost';
$dbname = 'mon_site';
$username = 'root'; // Votre utilisateur MySQL
$password = ''; // Votre mot de passe MySQL (ou vide sur certains serveurs locaux)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
