<?php

if (!isset($_POST['email']) || empty($_POST['email'])) {
    header('Location: /inscription_newsletter?message=You must enter your email!');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /inscription?message=Invalid Email');
    exit;
}

include '../includes/connexion_bdd.php';

$q = 'SELECT * FROM User WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['email']]);
$donnee = $req->fetchAll();

if (!$donnee) {
    header('Location: /inscription_newsletter?message=Create an account to receive our newsletters!');
    exit;
} else {

    $q = 'INSERT INTO Newsletter (User_idUser,date) VALUES (?,?)';
    $date = date("Y-m-d");
    $req = $bdd->prepare($q); 
    $results = $req->execute([$donnee[0]['idUser'],$date    ]);
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
    $mail->Host = 'patate.O2switch.net';
    $mail->SMTPAuth = true;
    if ($mail->SMTPAuth) {
        $mail->SMTPSecure = 'ssl';
        $mail->Username = 'derradji.ines@bessah.com';
        $mail->Password = 'P@ssword2023';
    }
    $mail->Port = 465;

    $mail->setFrom('derradji.ines@bessah.com', 'HOLOMUSIC');

    $q = 'SELECT User.email FROM Newsletter JOIN User ON User.idUser = Newsletter.User_idUser';
    $req = $bdd->prepare($q);
    $req->execute([]);
    $results = $req->fetchAll();

    foreach ($results as $row) {
        $email = strval($row['email']);
        $mail->addAddress($email);
    }

    $mail->isHTML(true);
    $mail->Subject = 'WELCOME TO OUR NEWSLETTER!';
    $mail->Body = 'Hi there!<br>
    Thank you for subscribing to our newsletter.<br>
    Stay updated with our latest <b>articles, news,</b> and insights about the music industry.';
    $mail->AltBody = 'News';

    $mail->send();

    header('Location: /index?success=1');
    exit;
} catch (Exception $e) {
    header('Location: /inscription_newsletter?success=2');
    exit;
}


?>