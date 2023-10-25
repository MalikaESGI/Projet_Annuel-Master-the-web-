<?php 
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';
$titre='Checkout';
$script='';
$link='../CSS/style_cart.css';
$link2='';
include '../includes/header_index.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        .container {
            
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color:white;
            margin-top:100px;
           }

        body{
            background-color:black;
        }

        #payment-form {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 5px;
        width: 100%;
        max-width: 500px;  
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color:rgba(102, 102, 102, 0.5);  
    }
       
    </style>

    
</head>
<body>

<div class="container mt-5">
        <form action="/paymentstripe" method="post" id="payment-form">
            <div class="form-row">
                <label for="card-holder-name" class="form-label">
                Card Holder's Name
                </label>
                <input id="card-holder-name" type="text" class="form-control">

                <label for="card-element" class="form-label">
                Credit or debit card
                </label>
                <div id="card-element" class="form-control"></div>
                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Payment</button>
        </form>
    </div>


    <?php
     echo '<div style="display: flex; justify-content: center; ">';
    if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert"  style="width:300px;  margin-top:20px; ">'
        . $_SESSION['error_message'] .
    '</div>';
    unset($_SESSION['error_message']);  // Clear the message
}

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success" role="alert"    style="width:300px; margin-top:20px;">'
        . $_SESSION['success_message'] .
    '</div>';
    unset($_SESSION['success_message']);  // Clear the message
}

echo '</div>';
?>
  


    <script>
    var stripe = Stripe('pk_test_51NRYZhAbu8oQ4nBfQ93voO8HJRY5gV7T7UwSRsz7viQQC3MwBUSVptOC6hRcXzhtYxjFLjWFTE7ccMGUNNL0gI5y00HbG4G15I');
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var card = elements.create('card', {style: style});
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log('Stripe token created:', result.token); // Logging token
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        console.log('Form contents before submission:', form); // Logging form
        console.log('Form submitted!'); // Log form submission
        form.submit();
    }
    </script>
</body>
</html>
