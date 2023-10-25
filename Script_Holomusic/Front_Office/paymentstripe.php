<?php
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';
$titre='Checkout';
$script='';
$link='../CSS/style_cart.css';
$link2='';
include '../includes/header_index.php';

require_once('../vendor/stripe/stripe-php/init.php');

\Stripe\Stripe::setApiKey('sk_test_51NRYZhAbu8oQ4nBfbkulhhF9n2m61GP0cVMMdor0GBFdWcZk4jSJECjEk1N0pU5eLtRpReQr9sY4LmW9Xq0HSlh500UVwh0q8D');

// Check if the stripeToken exists
if (!isset($_POST['stripeToken'])) {
    exit('No stripe token provided');
}

$token = $_POST['stripeToken'];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['total'])) {
    exit('No total provided in session');
}

$total = $_SESSION['total'];
$totalCents = $total * 100;

try {
    $charge = \Stripe\Charge::create([
        'amount' => $totalCents,
        'currency' => 'eur',
        'description' => 'payement',
        'source' => $token,
    ]);
  
$_SESSION['success_message'] = 'The payment was made successfully';
    header('Location: /payment');  // Redirect back to the payment page
    exit;
  
} catch (\Stripe\Error\Card $e) {
    $_SESSION['error_message'] = ' The payment has been rejected : ' . $e->getMessage();
    header('Location: /payment');
    exit;
} catch (\Exception $e) {
    exit('Caught exception: ' . $e->getMessage());
}

?>
