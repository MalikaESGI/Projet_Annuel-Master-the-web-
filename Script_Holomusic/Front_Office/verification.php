<?php
session_start();

if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['mdp']) || empty($_POST['mdp'])) {
    header('location: /connexion?message=You must fill in both fields');
    exit;
}

$email = trim($_POST['email']);
$email = htmlspecialchars($email);

$mdp = trim($_POST['mdp']);
$mdp = htmlspecialchars($mdp);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('location: /connexion?message=Invalid Email');
    exit;
}

include '../includes/connexion_bdd.php';

$q = 'SELECT idUser, username, password,Status FROM User WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$result = $req->fetch();

if (empty($result) || !password_verify($mdp, $result['password'])) {
    writeLogLine(false, $email);
    header('location: /connexion?message=Incorrect identifier');
    exit;
} else {
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $result['idUser'];
    $_SESSION['Status'] = $result['Status'];
    writeLogLine(true, $email);
    header('location:/index');
    exit;
}

function writeLogLine($success, $email)
{
    $log = fopen('log.txt', 'a+');
    $line = date('Y/m/d - H:i:s') . ' - Tentative de connexion ' . ($success ? 'réussie' : 'échouée') . $email . "\n";
    fputs($log, $line);
    fclose($log);
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    setcookie('email', $_POST['email'], time() + 24 * 3600);
}
?>