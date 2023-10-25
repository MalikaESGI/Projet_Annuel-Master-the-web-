<?php

include_once '../includes/connexion_bdd.php';

if (!isset($_GET['idUser']) || !is_numeric($_GET['idUser'])) {
    header('location: /admin/User_management?message= User Id invalide');
    exit;
}

if (isset($_POST['username']) || !empty($_POST['username']) ||
    isset($_POST['firstname']) || !empty($_POST['firstname']) ||
    isset($_POST['name']) || !empty($_POST['name'])) {
    if (isset($_POST['password']) || !empty($_POST['password'])) {
        $q = 'UPDATE User SET username = ?, firstname = ?,password = ?, email = ? WHERE idUser = ?';
        $req = $bdd->prepare($q);
        $req->execute([$_POST['username'], $_POST['firstname'], $_POST['password'], $_POST['email'], $_GET["idUser"]]);
    } else {
        $q = 'UPDATE User SET username = ?, firstname = ?, email = ? WHERE idUser = ?';
        $req = $bdd->prepare($q);
        $req->execute([$_POST['username'], $_POST['firstname'], $_POST['email'], $_GET['idUser']]);
    }
}
header('location: /admin/User_Management?message=Infomations du user : ' . $_GET['idUser'] . ' mise à jour avec succès');
exit;


?>