<?php
session_start();
require_once '../includes/connexion_bdd.php';

if (isset($_POST['mdp'], $_POST['confirm_mdp'], $_POST['token'], $_POST['email'])) {
    $password = $_POST['mdp'];
    $confirmPassword = $_POST['confirm_mdp'];
    $token = $_POST['token'];
    $email = $_POST['email'];

    if ($password !== $confirmPassword) {
        header('Location: /nv_mdp?email=' . $email . '&token=' . $token . '&error=Passwords do not match');
        exit;
    }

    $q = 'SELECT email FROM User WHERE token = :token';
    $req = $bdd->prepare($q);
    $req->execute([':token' => $token]);
    $result = $req->fetch();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $q = 'UPDATE User SET password = :password  WHERE email = :email';
    $stmt = $bdd->prepare($q);
    $stmt->execute([':password' => $hashedPassword, ':email' => $email]);

    if ($stmt->rowCount() > 0) {
        header('Location: /connexion?success=1');
        exit;
    } else {
        header('Location: /nv_mdp?email=' . $email . '&token=' . $token . '&error=An error occurred while updating the password');
        exit;
    }
} else {
    header('Location: /connexion');
    exit;
}
