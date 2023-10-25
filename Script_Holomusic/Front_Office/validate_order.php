<?php
session_start();

// vider le panier
$_SESSION['cart'] = array();

// Redirect to the payment page
header('Location: /form_payment');
exit;
