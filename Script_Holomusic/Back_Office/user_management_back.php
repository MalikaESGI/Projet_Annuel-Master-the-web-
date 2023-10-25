<?php
include '../includes/connexion_bdd.php';
$q = 'SELECT idUser,inscription_date,username,email,Status FROM User ORDER BY inscription_date DESC';
$req = $bdd->query($q);
$donnees = $req->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($donnees);
