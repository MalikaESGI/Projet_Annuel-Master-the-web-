<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Products';
$link = '../CSS/style_back_officeM.css';
include '../includes/header_backoffice.php';
include '../includes/connexion_bdd.php';
?>
<main>
    <div class="container pt-4">
        <div class="d-md-flex justify-content-between align-items-center my-5">
            <h2 class="mb-3 mb-md-0">Products</h2>
            <div class="order-md-2 mt-3 mt-md-0">
                <a href="add_products.php" class="btn btn-custom">Add New Product</a>
            </div>
            <div class="col-md">
                    <input class="form-control  mb-2 mb-md-0"  style="width:300px; margin-left:200px;"type="text" name="search" id="searchInput" placeholder="Search...">
                          
                          
                </div>
        </div>

        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Date of Publication</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="productTableBody" >
            <?php

            $products = $bdd->query('SELECT * FROM Products')->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?>€</td>
                    <td><?php echo $product['Description']; ?>€</td>
                    <td><?php echo $product['discount']; ?></td>
                    <td><?php echo $product['date']; ?></td>
                    <td><img  width="25px" src="../uploads/<?php echo $product['image']; ?>" alt="Product Image"  ></td>
                    <td>
                        <a href="/admin/modify_product?id=<?php echo $product['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="/admin/delete_product?id=<?php echo $product['id']; ?>" onclick="return confirm('Do you really want to delete <?php echo $product['name']; ?>');" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            let searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function () {
                let searchQuery = this.value; // Récupère la valeur de recherche
                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'search_products.php?search=' + encodeURIComponent(searchQuery), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('productTableBody').innerHTML = xhr.responseText;
                    } else {
                        document.getElementById('productTableBody').innerHTML = '<tr><td colspan="5">An error occurred during the search.</td></tr>';
                    }
                };
                xhr.onerror = function () {
                    // Gère les erreurs de la requête AJAX
                    document.getElementById('productTableBody').innerHTML = '<tr><td colspan="5">An error occurred during the search.</td></tr>';
                };
                xhr.send();
            });
        });
    </script>
</body>
</html>
