<?php

require_once '../includes/connexion_bdd.php';
if (isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('location: /forgot-mdp?message=Invalid Email');
        exit;
    } else {
        $q = 'SELECT idUser,username,name,birthdate FROM User WHERE email = ?';
        $req = $bdd->prepare($q);
        $req->execute([$_POST['email']]);
        $results = $req->fetchAll();
        if (empty($results)) {
            header('location: /forgot-mdp?message=Email does not exist !');
            exit;
        } else {
            include("mailTest2.php");
        }
    }
}
?>