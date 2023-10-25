<?php
session_start();
include '../includes/connexion_check_admin.php';
require_once '../includes/connexion_bdd.php';
$id = $_GET['id'];
$sqlState = $bdd->prepare('DELETE FROM Event WHERE id=?');
$supprime = $sqlState->execute([$id]);
header('location: /admin/list_events');

?>