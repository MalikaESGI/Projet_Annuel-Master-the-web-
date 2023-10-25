<?php
session_start();
include "../includes/connexion_check.php";
include '../includes/connexion_bdd.php';

if (isset($_GET['idConversation'])) {
    $parametre = $_GET['idConversation'];

    $q = 'SELECT date, text, User_id_Sender, User_id_Reciever, ConversationID FROM Message WHERE ConversationID = ?';
    $req = $bdd->prepare($q);
    $req->execute([$parametre]);
    $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($donnees);

    header('Content-Type: application/json');
    echo $json;
}