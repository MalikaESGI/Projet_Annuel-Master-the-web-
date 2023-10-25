<?php
session_start();
include '../includes/connexion_bdd.php';

if (!isset($_SESSION['registration_data'])) {
    header('Location: inscription.php');
    exit;
}

$registration_data = $_SESSION['registration_data'];

$q = 'INSERT INTO User (username, firstname, birthdate, email, password, Status, token) VALUES(?, ?, ?, ?, ?,1, ?)';
$req = $bdd->prepare($q);
$results = $req->execute([
    $registration_data['username'],
    $registration_data['name'],
    $registration_data['date_of_birth'],
    $registration_data['email'],
    $registration_data['mdp'],
    $registration_data['token']
]);

if (!$results) {
    echo 'Connection error!';
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/PHP_MAILER/src/Exception.php';
require '/var/www/html/PHP_MAILER/src/PHPMailer.php';
require '/var/www/html/PHP_MAILER/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'patate.O2switch.net';
    $mail->SMTPAuth   = true;
    if ($mail->SMTPAuth) {
        $mail->SMTPSecure = 'ssl';
        $mail->Username   = 'derradji.ines@bessah.com';
        $mail->Password   = 'P@ssword2023';
    }
    $mail->Port = 465;

    $mail->setFrom('derradji.ines@bessah.com', 'HOLOMUSIC');

    
    $email = $registration_data['email'];
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'WELCOME TO HOLOMUSIC!';
    $mail->Body    = 'Hi there!<br>
    Welcome to HOLOMUSIC! <br>
     We are absolutely thrilled to have you on board. Embark on an enriching journey with us into the entrancing world of music.<br>
      Our platform offers a unique blend of melodies, tunes, and harmonies that are sure to stir your soul. <br>
      Be it classical symphonies or contemporary beats, we have it all. <br>
      At HOLOMUSIC,  we strive to celebrate the diversity and depth of music, and we are excited for you to explore, enjoy, and grow with us.
     Stay updated with our latest <b>articles, news,</b> and insights about the music industry.';
    $mail->AltBody = 'News';

    $mail->send();
    session_destroy();
    header('Location: /connexion?success=1');
    exit;
  

} catch (Exception $e) {
    header('Location: /inscription?success=2');
    exit;
}

?>
