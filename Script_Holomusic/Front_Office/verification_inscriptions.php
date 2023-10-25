<?php
session_start();
include '../includes/connexion_bdd.php';

if (!isset($_POST['email']) || empty($_POST['email']) ||
  !isset($_POST['mdp']) || empty($_POST['mdp']) ||
  !isset($_POST['username']) || empty($_POST['username']) ||
  !isset($_POST['name']) || empty($_POST['name']) ||
  !isset($_POST['date_of_birth']) || empty($_POST['date_of_birth'])){

    header('location: /inscription?message=You must fill all fields!');
    exit;
}

$email = trim($_POST['email']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('location: /inscription?message=Invalid Email');
    exit;
}

$email = htmlspecialchars($email);
$mdp = trim($_POST['mdp']);
$mdp = htmlspecialchars($mdp);
$username = trim($_POST['username']);
$username = htmlspecialchars($username);
$name = trim($_POST['name']);
$name = htmlspecialchars($name);
$date_of_birth = trim($_POST['date_of_birth']);
$date_of_birth = htmlspecialchars($date_of_birth);

if (strlen($mdp) < 6 || strlen($mdp) > 20 ) {
    header('location: /inscription?message=The password must be between 6 and 20 characters !');
    exit;	
}

if ($mdp != $_POST['mdp-confirm']) {
  header('location: /inscription?message=Passwords do not match!');
  exit;
}

if (isset($name) && !empty($name)) {
    setcookie('name', $name, time() + 3600);
}
if (isset($username) && !empty($username)) {
    setcookie('username', $username, time() + 3600);
}


if (isset($date_of_birth) && !empty($date_of_birth)) {
    setcookie('date_of_birth', $date_of_birth, time() + 3600);
}
if (isset($email) && !empty($email)) {
    setcookie('email', $email, time() + 3600);
}


$q = 'SELECT idUser FROM User WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$results = $req->fetchAll();

if (!empty($results)) {
    header('location: /inscription?message=Email already used!');
    exit;
}

$q = 'SELECT idUser FROM User WHERE username = ?';
$req = $bdd->prepare($q);
$req->execute([$username]);
$results = $req->fetchAll();

if (!empty($results)) {
    header('location: /inscription?message=Username already used!');
    exit;
}
$token = ''; 
$hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
$_SESSION['registration_data'] = [
    'username' => htmlspecialchars($username),
    'name' => htmlspecialchars($name),
    'date_of_birth' => htmlspecialchars($date_of_birth),
    'email' => htmlspecialchars($email),
    'mdp' => $hashedPassword,
    'token' => $token
];

header('Location: /captcha_inscription');
exit;