<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="<?= $script; ?>" defer></script>
    <link type="text/css" href="<?php echo $link ?>" rel="stylesheet">

    <title><?php echo $titre ?></title>
</head>

<body data-bs-theme="dark">
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/index">HolowMusic</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'User Management' ? 'active' : ''; ?>" href="/admin/User_Management">User Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Products' ? 'active' : ''; ?>" href="/admin/product_list">Products
                                List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Events' ? 'active' : ''; ?>" href="/admin/list_events">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Sells Management' ? 'active' : ''; ?>" href="/admin/Sell_Sheet">Sells
                                Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Article Management' ? 'active' : ''; ?>" href="/admin/gestion_artcl">Article Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Comment Management' ? 'active' : ''; ?>" href="/admin/gestion_comment">Comment Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $titre == 'Captcha Management' ? 'active' : ''; ?>" href="/admin/Captcha_pictures">Captcha Management
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>