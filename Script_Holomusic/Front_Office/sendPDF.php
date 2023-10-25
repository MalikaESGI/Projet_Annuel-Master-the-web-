<?php
session_start();
require '../fpdf/fpdf.php';
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';

$q = 'SELECT name, firstname, birthdate, username, email, Status FROM User WHERE idUser = :userId';
$req = $bdd->prepare($q);
$req->execute(['userId' => $_SESSION['user_id']]) or die(print_r($req->errorInfo(), true));
$donnees = $req->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(40, 10, 'Name: ' . $donnees[0]['name'], 0, 1);
$pdf->Cell(40, 10, 'First name: ' . $donnees[0]['firstname'], 0, 1);
$pdf->Cell(40, 10, 'Birth date: ' . $donnees[0]['birthdate'], 0, 1);
$pdf->Cell(40, 10, 'Username: ' . $donnees[0]['username'], 0, 1);
$pdf->Cell(40, 10, 'Email: ' . $donnees[0]['email'], 0, 1);
$status = ($donnees[0]['Status'] == '1') ? 'User' : 'Admin';
$pdf->Cell(40, 10, 'Status: ' . $status, 0, 1);

$pdf->Output('D', 'filename.pdf');
