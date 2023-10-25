<?php
session_start();
include '../includes/connexion_bdd.php';
$products = $bdd->query('SELECT * FROM Products');

$titre = 'Shop';
$link = '../CSS/prod.css';
include '../includes/header_index.php';
?>

<body>
<div class="container mt-4">
    <div class="row">
        <div class="d-md-flex justify-content-between align-items-center my-5">
            <h1 class="mb-3 mb-md-0 text ">Discover our store : Find the<span class="text-custom"> perfect </span>
                match for your style <br>Shop now and take your music to the <span class="text-custom"> next </span>level !</h1>
        </div>
        <section  class="mt-5 mb-5">
            <div class="row">
                <?php while ($product = $products->fetch()) { ?>
                    <div class="col-md-4">
                        <div class="card mb-5" style="width: 20rem;"  >
                            <img src="../uploads/<?= $product['image'] ?>" class="card-img-top " alt="Product Image" >
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <?php if($product['discount'] > 0): ?>
                            <?php $new_price = $product['price'] - ($product['price'] * $product['discount'] / 100); ?>
                            <p class="card-text"><del><?= $product['price'] ?>€</del><br><strong>
                            <?= number_format($new_price, 2) ?>€</strong></p>
                            <?php else: ?>
                            <p class="card-text">Price: <?= $product['price'] ?>€</p>
                            <?php endif; ?>
                            <a href="/product_details?id=<?php echo $product['id']?>"
                            class="btn btn-custom mt-3 mb-3">See more</a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
</div>
</body>
<?php
    include '../includes/footer.php';
?>