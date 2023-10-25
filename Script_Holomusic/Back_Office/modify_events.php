<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Modify Events';
$link = '../CSS/style_back_officeM.css';
include '../includes/header_backoffice.php';
include '../includes/connexion_bdd.php';
?>
<div class="container py-2">
    <h2>Edit events</h2>
    <?php
    $id = $_GET['id'];
    $sqlState = $bdd->prepare('SELECT Event.*, Event_Category.name AS category FROM Event
                            JOIN Event_Category ON Event.id_category = Event_Category.id WHERE Event.id = ?');
    $sqlState->execute([$id]);
    $event = $sqlState->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['modify'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $date = $_POST['date'];
        $place = trim($_POST['place']);
        $url = trim($_POST['url']);
        $category = $_POST['category'];

        $image = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            $maxSize = 2 * 1024 * 1024;
            if ($img_size > $maxSize) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Sorry, your file is too large
                </div>
                <?php
            } else {
                $img_ex = pathinfo($image, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "gif");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                    $image = $new_img_name;
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        You can't upload files of this type
                    </div>
                    <?php
                    exit; 
                }
            }
        } else {
            $image = $event['image'];
        }

        if (!empty($name) && !empty($description) && !empty($category) && !empty($date)) {
            if ($date <= date('Y-m-d')) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Choose a future date
                </div>
                <?php
            } else {
                $sqlState = $bdd->prepare('UPDATE Event SET name=?, description=?, date=? , id_category=?, place=?, url=?, image=? WHERE id=?');
                $sqlState->execute([htmlspecialchars($name), htmlspecialchars($description), htmlspecialchars($date), htmlspecialchars($category), htmlspecialchars($place), htmlspecialchars($url),$image, htmlspecialchars($id)]);
                header('location: /admin/list_events');
                exit;
            }
        } else {
            if (empty($name)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The name of the artist is required
                </div>
                <?php
            }
            if (empty($description)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The description is required
                </div>
                <?php
            }
            if (empty($category)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The category is required
                </div>
                <?php
            }
            if (empty($date)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The date is required
                </div>
                <?php
            }
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="id" value="<?php echo $event['id'] ?>">
        <label class="form">Artist name</label>
        <input type="text" class="form-control custom" name="name" value="<?php echo $event['name'] ?>">
        <label class="form">Description</label>
        <textarea class="form-control custom" name="description"><?php echo $event['description'] ?></textarea>
        <label class="form">Date</label>
        <input type="date" class="form-control custom" name="date" value="<?php echo $event['date'] ?>">
        <label class="form">Category</label>
        <select name="category" class="form-select custom-select">
            <option value="" disabled selected>Select ...</option>
            <option value="1" <?php echo $event['category'] == 'Concert' ? 'selected':''; ?>>Concert</option>
            <option value="2" <?php echo $event['category'] == 'Album' ? 'selected':''; ?>>New Album</option>
            <option value="3" <?php echo $event['category'] == 'Tour' ? 'selected':''; ?>>Tour</option>
        </select>
        <label class="form">Place</label>
        <input type="text" class="form-control custom" name="place" value="<?php echo $event['place'] ?>">
        <label class="form">URL</label>
        <textarea class="form-control custom" name="url"><?php echo $event['url'] ?></textarea>
        <label class="form">Image</label>
        <input type="file" class="form-control custom" name="image">
        <input type="submit" value="Modify" class="btn btn-custom my-2" name="modify">
    </form>
</div>
</body>
</html>
