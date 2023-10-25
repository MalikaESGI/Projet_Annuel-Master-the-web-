<?php 
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';
$titre='Cart';
$script='';
$link='../CSS/style_cart.css';
$link2='';
include '../includes/header_index.php';
?>

<div class="container mt-5">

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_POST['id']) && $_POST['id'] != '') {
        $stmt = $bdd->prepare('SELECT * FROM Products WHERE id = ?');
        $stmt->execute([$_POST['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $productId = $product['id'];
            $product['price'] = $product['price'] - ($product['price'] * $product['discount'] / 100);

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantite']++;
            } else {
                $product['quantite'] = 1;
                $_SESSION['cart'][$productId] = $product;
            }
        }
    }

    if (isset($_POST['update'])) {
        $productId = $_POST['update'];
        $quantity = $_POST['quantity'];

        if ($quantity > 0 && isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantite'] = $quantity;
        }
    }

    if (isset($_POST['delete'])) {
        unset($_SESSION['cart'][$_POST['delete']]);
    }

    if (isset($_POST['reset'])) {
        $_SESSION['cart'] = array();
    }
}

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo '<h1 class="text-center">Your cart</h1>';
    echo '<table class="table">';
    echo '<thead><tr><th>Image</th><th>Product name</th><th>Price</th><th>Quantite</th><th>Total</th><th>Action</th></tr></thead>';
    echo '<tbody>';

    $total = 0;
    foreach ($_SESSION['cart'] as $productId => $product) {
        if (empty($product['id']) || empty($product['name']) || empty($product['price'])) {
            unset($_SESSION['cart'][$productId]);
            continue;
        }
        $nameProduct = htmlspecialchars($product['name'] ?? '');
        $priceProduct = htmlspecialchars($product['price'] ?? 0);
        $quantiteProduct = htmlspecialchars($product['quantite'] ?? 0);
        $idProduct = htmlspecialchars($product['id'] ?? '');

        $totalProduct = $priceProduct * $quantiteProduct;
        $total += $totalProduct;

        echo '<tr><td><img src="../uploads/' . htmlspecialchars($product['image']) . '" width="50" height="50" alt="Product Image"></td><td>' . $nameProduct . '</td><td>' . $priceProduct . '€</td><td>';

        echo '<form action="/cart" method="post">';
        echo '<input type="hidden" name="update" value="' . $idProduct . '">';
        echo '<input type="number"  name="quantity" value="' . $quantiteProduct . '" min="1"  style="width:100px;margin-right:5px; margin-top:2px;">';
        echo '<button type="submit" class="btn btn-primary btn-sm">Update</button>';
        echo '</form>';
        echo '</td><td>' . $totalProduct . '€</td><td>';
        echo '<form action="/cart" method="post">';
        echo '<input type="hidden" name="delete" value="' . $idProduct . '">';
        echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
        echo '</form></td></tr>';
    }

    echo '<tr><td colspan="3" class="text-right"><strong>Total</strong></td><td>' . $total . '€</td></tr>';

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<h2 class="text-center">Your cart is empty.</h2>';
}
$_SESSION['total']=$total;
?>

    <div class="d-flex justify-content-end">
        <form action="/cart" method="post" style="display: inline-block; margin-right: 10px;">
            <input type="hidden" name="reset" value="1">
            <button type="submit" class="btn btn-warning btn-sm">Empty the card</button>
        </form>

            <form action="/validate_order" method="post" style="display: inline-block;">
        <button type="submit" class="btn btn-success btn-sm">Checkout</button>
    </form>

    </div>
    </div>

</body>
</html>
