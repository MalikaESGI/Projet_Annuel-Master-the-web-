<?php
session_start();
//include '../includes/connexion_check.php';
$link = '../CSS/style_index.css';
$link2 = '';
$titre = 'Acceuil';
$script = '../JS/slider.js';
include '../includes/header_index.php';
include '../includes/connexion_bdd.php';
include '../includes/darck_mode.php';
?>
<main>
    <div id="popup-container">
        <h3>Respect de la vie privée</h3>
        <p>Nous utilisons des cookies pour améliorer votre expérience sur notre site web.</p>
        <p>En continuant à utiliser ce site, vous acceptez notre utilisation des cookies.</p>
        <button onclick="acceptCookies()">Accepter</button>
        <button onclick="hidePopup()">Refuser</button>
    </div>
    <section>
        <div id="slider">
            <div class="img">
                <img src="../asset/concert1.webp" alt="concert1" id="slide" />
            </div>
            <div id="precedent" onclick="ChangeSlide(-1)">&lt;</div>
            <div id="suivant" onclick="ChangeSlide(1)">&gt;</div>
        </div>
    </section>
    <section class="products" id="products">
        <div class="heading">
            <h2>Category</h2>
        </div>
        <div class="category">
            <?php
            $q = 'SELECT name FROM Category LIMIT 4';
            $req = $bdd->prepare($q);
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($donnees as $index => $value) {
                echo '
                    <div id="c">
                        <a href=" /read_article" class="btn rounded-pill">' . $value['name'] . '</a>
                    </div>';
            }
            ?>
        </div>
        <h2 class="mb-5 mt-5">Articles</h2>
        <div class="products-container">

            <?php
            $q = 'SELECT * FROM Article LIMIT 6';
            $req = $bdd->prepare($q);
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($donnees as $index => $value) {
                echo ' 
                    <div class="box">
                    <img class="image" src="../uploads/' . $value['image'] . '" alt="image"/>
                    <p id="d">' . $value['date_of_publ'] . '</p>
                    <h2 id="title">' . $value['title'] . '</h2>
                    <p id="description" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap">' . $value['body'] . '</p>
                    <div class="content">
                        <a href="/read_article" target="_blank" class="btn rounded-pill"
                    >Read More</a
                    >
                    </div>
                    </div>';
            }
            ?>

        </div>
    </section>
    <section class="end-products">
        <p style="background: none">
            Visit our Articles page to explore more <br />
            captivating content and dive deeper into our collection of articles.
        </p>
        <a href="/read_article" class="btn btn-danger">See more</a>
    </section>



    <section>
        <h1 id="titre">Visit Our Store</h1>
        <section class="produits">
            <?php
            $q = 'SELECT * FROM Products LIMIT 3';
            $req = $bdd->prepare($q);
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($donnees as $index => $value) {
                echo '
                    <div class="card text-center">
                    <div class="card-image img-' . ($index + 1) . '" style="background-image: url(\'../uploads/' . $value['image'] . '\');">
                    </div>
                    <h2>' . $value['name'] . '</h2>
                    <h2>' . '<br/>' . $value['price'] . '€</h2>
                    <a href="/shop">Buy now</a>
                    </div>
                    ';
            }
            ?>

        </section>

        <a href="shop.html" class="btn3">Shop at our store</a>
    </section>

    <section class="suscribe">
        <div class="S">
            <p style="background: none">
                Interested to get notified ? <br />
                Suscribe and get <span>the most</span> piping
                <span>hot news</span> of the week, emailed straight to your inbox.
            </p>
            <a href="/inscription_newsletter" class="btn2">Suscribe</a>
        </div>
    </section>
</main>

<?php include '../includes/footer.php' ?>