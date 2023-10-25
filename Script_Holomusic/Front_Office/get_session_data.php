<?php
session_start();

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $session = $_SESSION['user_id'];
    header('Content-Type: application/json');
    echo json_encode($session);
}