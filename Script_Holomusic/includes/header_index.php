<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $titre ?></title>
    <link rel="shortcut icon" href="../asset/Logotab.ico">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <script src="<?php echo $script ?>" type="text/javascript" defer></script>
    <style>
        body {
            background-color: white;
            color: white;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../CSS/style_footer.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $link ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $link2 ?>" />
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid text-center">
                <a class="navbar-brand  px-3 mb-2" href="/index">
                    <img class="" src="../asset/Logo.svg" width="50px" height="50px" alt="logo">
                </a>
                <p class="fw-bold fs-3 mt-3 text-center">HOLOWMUSIC</p>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div>
                    <label id="dark-change"></label>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        if (isset($_SESSION['Status']) && $_SESSION['Status'] == 2) {
                            echo '<a class=" nav-link px-3" href="/admin/User_Management">Back Office</a>';
                        }
                        echo '<a class=" nav-link px-3  ' . ($titre == 'Acceuil' ? 'active' : '') . '" href="/index">Home</a>
                                <a class=" nav-link px-3  ' . ($titre == 'Profil' ? 'active' : '') . '" href="/profil">Profil</a>
                                <a class=" nav-link px-3  ' . ($titre == 'Messagerie' ? 'active' : '') . '" href="/messagerie">Messagerie</a>
                                <a class=" nav-link px-3  ' . ($titre == 'Articles' ? 'active' : '') . '" href="/read_article">Articles</a>
                                <a class=" nav-link px-3  ' . ($titre == 'Evènements' ? 'active' : '') . '" href="/events_front">Events</a>
                                <a class=" nav-link px-3  ' . ($titre == 'Shop' ? 'active' : '') . '" href="/product_front">Shop</a>
                                <a class="btn btn-danger px-3"';
                        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
                            echo 'href="/connexion">Login';
                        } else {
                            echo 'href="/deconnexion">Deconnexion';
                        }
                        echo '</a>
                    </li>';
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>