<?php
try {
    $bdd = new PDO('mysql:host=51.178.30.38;port=3306;dbname=MasterTheWeb', 'esgi',
        'DB%8T1N1NE&wZ64g4DB@', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}