<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Events';
$link = '../CSS/style_back_officeM.css';
include '../includes/header_backoffice.php';
include '../includes/connexion_bdd.php';
?>
<main>
    <div class="container pt-5">
        <div class="d-md-flex justify-content-between align-items-center my-5">
            <h2 class="mb-3 mb-md-0">Event</h2>

            <div class="order-md-2 mt-3 mt-md-0">
                <a href="add_events.php" class="btn btn-custom">Add New Event</a>
            </div>
            <div class="col-md">
                    <input class="form-control  mb-2 mb-md-0"  style="width:300px; margin-left:200px;"type="text" name="search" id="searchInput" placeholder="Search...">
                </div>
        </div>
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th>#ID</th>
                <th>Artist name</th>
                <th>description</th>
                <th>Date_of_event</th>
                <th>Category</th>
                <th>Place</th>
                <th>Url</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody id="eventTableBody">
            <?php
            $events = $bdd->query('SELECT Event.*, Event_Category.name AS category FROM Event
            JOIN Event_Category ON Event.id_category = Event_Category.id')->fetchAll(PDO::FETCH_ASSOC);
            foreach ($events as $event) {
                $eventId = $event['id'];
                $eventDate = $event['date'];
                $currentDate = date('Y-m-d');

                if ($eventDate <= $currentDate) {
                    $deleteStmt = $bdd->prepare('DELETE FROM Event WHERE id = ?');
                    $deleteStmt->execute([$eventId]);
                    continue;
                }
                ?>
                <tr>
                    <td><?php echo $event['id'] ?></td>
                    <td><?php echo $event['name'] ?></td>
                    <td><?php echo $event['description'] ?></td>
                    <td><?php echo $event['date'] ?></td>
                    <td><?php echo $event['category'] ?></td>
                    <td><?php echo $event['place'] ?></td>
                    <td><?php echo $event['url'] ?></td>
                    <td><img width="25px" src="../uploads/<?php echo $event['image']; ?>" alt="event Image"></td>
                    <td>
                        <a href="/admin/modify_events?id=<?php echo $event['id'] ?>" class="btn btn-info">Edit</a>
                        <a href="/admin/delete_events?id=<?php echo $event['id'] ?>"
                           onclick="return confirm('Do you really want to delete the event');"
                           class="btn btn-danger">Delete</a>
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
                let searchQuery = this.value;

                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'search_events?search=' + encodeURIComponent(searchQuery), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('eventTableBody').innerHTML = xhr.responseText;
                    } else {
                        document.getElementById('eventTableBody').innerHTML = '<tr><td colspan="5">An error occurred during the search.</td></tr>';
                    }
                };
                xhr.onerror = function () {
                    document.getElementById('eventTableBody').innerHTML = '<tr><td colspan="5">An error occurred during the search.</td></tr>';
                };
                xhr.send();
            });
        });
    </script>
</body>
</html>
