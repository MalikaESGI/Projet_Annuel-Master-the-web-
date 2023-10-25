<?php
session_start();
include '../includes/connexion_check_admin.php';
include '../includes/connexion_bdd.php';

if(isset($_GET['id'])){
    $q = 'DELETE FROM Newsletter WHERE `User_idUser` = :userId';
    $req = $bdd->prepare($q);
    $req->execute(['userId' => $_GET['id']]);
    
    $q = 'DELETE FROM User WHERE idUser=:userId';
    $req = $bdd->prepare($q);
    $req->execute(['userId' => $_GET['id']]);
    
    header('location: /admin/User_Management');
        exit;
}