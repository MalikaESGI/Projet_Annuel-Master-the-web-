<?php
session_start();
include '../includes/connexion_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/Style_inscp_newsletter.css"/>
    <title>Sign in</title>
</head>
<body>

<main>
    <div class="box1">
        <div class="inner-box">
            <div class="formulaire">
                <form action="/verification_newsletter" method="POST" class="sign-in">
                    <div class="head1">
                        <p> Join our newsletter for captivating articles, expert insights,<br>
                            and the latest trends in the music industry.</p>
                    </div>
                    <div class="actual-form">
                        <div class="input">
                            <input type="email" name="email" placeholder="Email" class="input-field">
                        </div>
                        <?php
                        if (isset($_GET['message']) && !empty($_GET['message'])) {
                            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
                        }
                        ?>
                        <input type="submit" value="Suscribe" class="sign-btn">
                    </div>
                </form>
            </div>
            <div class="sign-up">
            </div>
        </div>
    </div>
</main>
</body>
</html>
