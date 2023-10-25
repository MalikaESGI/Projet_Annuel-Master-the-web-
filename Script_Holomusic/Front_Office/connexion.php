<?php
if (isset($_SESSION['email']) || !empty($_SESSION['email'])) {
    header('location: /index');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/Style_connx.css"/>
    <title>Sign in</title>
</head>
<body>
<main>
    <div class="box1">
        <div class="inner-box">
            <div class="formulaire">
                <form action="/verification" method="POST" class="sign-in">
                    <div class="head1">
                        <h1>Sign in</h1>
                    </div>
                    <div class="actual-form">
                        <div class="input">
                            <input type="email" name="email" placeholder="Email" class="input-field">
                        </div>
                        <div class="input">
                            <input type="password" name="mdp" placeholder="Password" class="input-field">
                        </div>
                        <?php

                        if (isset($_GET['message']) && !empty($_GET['message'])) {
                            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
                        }

                        ?>

                        <input type="submit" value="login" class="sign-btn">


                        <p class="text-help">
                            Forgotten your password ?
                            <a href="/forgot-mdp">Get help</a> signing in
                        </p>


                    </div>
                </form>
               
            </div>

            <div class="sign-up">
                <h1>New here ?</h1>
                <a href="/inscription" class="sign-up-btn">Sign up</a>
            </div>


        </div>
    </div>
</main>
</body>
</html>
