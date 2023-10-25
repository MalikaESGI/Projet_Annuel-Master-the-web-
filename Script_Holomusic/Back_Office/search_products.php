<?php
include '../includes/connexion_bdd.php';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];

    $query = "SELECT * FROM Products WHERE name LIKE :searchQuery";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':searchQuery', $searchQuery . '%');
    $stmt->execute();
} else {
    $query = "SELECT * FROM Products";
    $stmt = $bdd->query($query);
}

if ($stmt->rowCount() > 0) {
    ob_start();
    while ($product = $stmt->fetch()) {
        ?>
        <tr>
            <th scope="row"><?= $product['id']; ?></th>
            <td><?= $product['name']; ?></td>
            <td><?= $product['price']; ?></td>
            <td><?= $product['Description']; ?></td>
            <td><?= $product['Discount']; ?></td>
            <td><?= $product['date']; ?></td>
            <td><img width="25px" src="../uploads/<?= $product['image']; ?>" alt="Product Image"></td>
            <td>
                <a href="/admin/modify_product?id=<?= $product['id'] ?>" class="btn btn-info">Modify</a>
                <a href="/admin/delete_product?id=<?= $product['id'] ?>" onclick="return confirm('Do you really want to delete the event');" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php
    }
    $html = ob_get_clean();
    echo $html;
} else {
    echo '<tr><td colspan="5">No product found.</td></tr>';
}
?>
