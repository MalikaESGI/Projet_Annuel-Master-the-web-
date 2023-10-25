<?php
include '../includes/connexion_bdd.php';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $query = "SELECT Event.*, Event_Category.name AS category 
    FROM Event 
    JOIN Event_Category ON Event.id_category = Event_Category.id 
    WHERE Event.name LIKE :searchQuery OR Event.place LIKE :searchQuery OR Event_Category.name LIKE :searchQuery";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':searchQuery', $searchQuery . '%');
    $stmt->execute();
} else {
    $query = "SELECT Event.*, Event_Category.name AS category FROM Event
            JOIN Event_Category ON Event.id_category = Event_Category.id";
    $stmt = $bdd->query($query);
}
if ($stmt->rowCount() > 0) {
    ob_start();
    while ($event = $stmt->fetch()) {
        ?>
        <tr>
            <th scope="row"><?= $event['id']; ?></th>
            <td><?= $event['name']; ?></td>
            <td><?= $event['description']; ?></td>
            <td><?= $event['date']; ?></td>
            <td><?= $event['category']; ?></td>
            <td><?= $event['place']; ?></td>
            <td><?= $event['url']; ?></td>
            <td><img src="../uploads/<?= $event['image']; ?>" alt="Product Image" width="25px"></td>
            <td>
                <a href="/admin/modify_product?id=<?= $event['id'] ?>" class="btn btn-info">Modify</a>
                <a href="/admin/delete_product?id=<?= $event['id'] ?>" onclick="return confirm('Do you really want to delete the event');" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php
    }
    $html = ob_get_clean();
    echo $html;
} else {
    echo '<tr><td colspan="5">Event not found.</td></tr>';
}
?>
