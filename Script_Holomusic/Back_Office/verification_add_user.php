<?php
//verfication admin co
include '../includes/connexion_bdd.php';
var_dump($_POST['status']);
$q = 'INSERT INTO User (username,name,firstname,password,birthdate,email,Status) VALUES (:username,:name,:firstname,:password,:birthdate,:email,:status)';
$req = $bdd->prepare($q);
$req->execute(['username' => $_POST['username'],
    'firstname' => $_POST['firstname'],
    'name' => $_POST['name'],
    'password' => $_POST['password'],
    'birthdate' => $_POST['birthdate'], 'email' => $_POST['email'], 'status' => $_POST['status']
]);
header('location: /admin/User_management?message= User correctement créer');
?>