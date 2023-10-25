<?php
session_start();
require_once '../includes/connexion_bdd.php';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} else {
    
    header('Location: /connexion');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/Style_nv_mdp.css"/>
    <title>New password</title>
</head>
<body>
<main>
    <div class="box1">
        <div class="inner-box">
            <div class="formulaire">
                <form action="/verification-nv_mdp" method="POST" class="sign-in">
                    <div class="head1">
                        <h1>Your new password</h1>
                        <p>Please enter your new password.</p>
                    </div>
                    <div class="input">
                        <input type="password" name="mdp" placeholder="Password" class="input-field">
                    </div>
                    <div class="head1">
                        <p>Confirm your password.</p>
                    </div>
                    <div class="input">
                        <input type="password" name="confirm_mdp" placeholder="Password" class="input-field">
                    </div>

                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">

                    <input type="submit" value="Submit" class="sign-btn">

                    <?php
                    if (isset($_GET['error']) && !empty($_GET['error'])) {
                        echo '<p>' . htmlspecialchars($_GET['error']) . '</p>';
                    }
                    ?>
                    <div class="head1">
                        <?php
                        $successParam = htmlspecialchars($_GET['success'] ?? null);
                        if ($successParam === '1') {
                            echo 'Password reset successful';
                        } elseif ($successParam === '2') {
                            echo 'An error occurred.<br>Please try again.';
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
