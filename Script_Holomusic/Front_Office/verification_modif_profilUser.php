<?php
session_start();
include '../includes/connexion_check.php';
include '../includes/message.php';
include '../includes/connexion_bdd.php';

if (isset($_POST['username']) || !empty($_POST['username']) ||
    isset($_POST['firstname']) || !empty($_POST['firstname']) ||
    isset($_POST['name']) || !empty($_POST['name'])) {


    if ($_FILES['image']['error'] != 4) { //fichier non vide
        $acceptable = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($_FILES['image']['type'], $acceptable)) {
            header('location: /profil?message=L\'image doit être de type jpeg, png ou gif.&type=danger');
            exit;
        }
        $maxSize = (2 * 1024) * 1024;
        //verification de la taille du fichier
        if ($_FILES["image"]['size'] >= $maxSize) {
            header('location: /profil?message=L\'image est trop grosse. &type=danger');
            exit;
        }
        //Enregistrer le fichier sur le serveur
        //Créer un dossier upload si il n'existe pas
        if (!file_exists("../uploads")) {
            mkdir('../uploads');
        }
        $from = $_FILES['image']['tmp_name'];
        $array = explode(".", $_FILES['image']['name']);
        $ext = end($array);
        $fileName = 'image-' . time() . '.' . $ext;

        $destination = '../uploads/' . $fileName;

        $move = move_uploaded_file($from, $destination); //boolean vrai ou faux
        if (!$move) {
            header('location: /profil?message=Erreur lors de l\'enregistrement de l\'image. &type=danger');
            exit;
        }
    }
    if (isset($_POST['password']) || !empty($_POST['password'])) {
        $q = 'UPDATE User SET username = ?, firstname = ?,password = ?, email = ? ,image = ? WHERE email = ?';
        $req = $bdd->prepare($q);
        $req->execute([$_POST['username'], $_POST['firstname'], $_POST['password'], $_POST['email'], $destination, $_SESSION['email']]);
    } else {

        header('location: /profil?message=Les champs nom, prénom, email, username doivent être remplis.&type=danger');
        exit;
    }
}
?>