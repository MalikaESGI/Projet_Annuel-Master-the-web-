<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Add Events';
$link = '../CSS/style_back_officeM.css';
$script='';
include '../includes/header_backoffice.php';
include '../includes/connexion_bdd.php';

function save($name, $description,$date,$category,$place, $url) {
    $_SESSION['name'] = $name;
    $_SESSION['description'] = $description;
    $_SESSION['date'] = $date;
    $_SESSION['id_category'] = $category;
    $_SESSION['place'] = $place;
    $_SESSION['url'] = $url;
 
}
function clear() {
    unset($_SESSION['name']);
    unset($_SESSION['description']);
    unset($_SESSION['date']);
    unset($_SESSION['id_category']);
    unset($_SESSION['place']);
    unset($_SESSION['url']);
}
?>

<div class="container pt-5">
    <h2>Add New event</h2>
    <?php
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $place = trim($_POST['place']);
        $url = trim($_POST['url']);
        $category = $_POST['id_category'];
        $date = $_POST['date'];

        save($name, $description, $date, $category, $place,$url);

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
                exit;
            } else {
                $img_ex = pathinfo($image, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "gif");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        You can't upload files of this type
                    </div>
                    <?php
                exit;
                }
            }
        }
        if (!empty($name) && !empty($description) && !empty($image) && !empty($date) && !empty($category)) {
            if ($date <= date('Y-m-d')) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Choose a future date
                </div>
                <?php
               
               
            }elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The URL is not valid
                </div>
                <?php
               
                
            } else {

                $res = $bdd->prepare('INSERT INTO Event(name,description,date,id_category,place,url,image) VALUES(?,?,?,?,?,?,?)');
                $res->execute([htmlspecialchars($name), htmlspecialchars($description),htmlspecialchars($date), htmlspecialchars($category),
                 htmlspecialchars($place), htmlspecialchars($url), $img_upload_path]);
                ?>
                <div class="alert alert-success" role="alert">
                    The event is added successfully
                </div>
                <?php
                 clear();
                 
            }
        
        } elseif (empty($name)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The name of the artist is required6
                </div>
                <?php
               
            }elseif (empty($description)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The description is required
                </div>
                <?php
                
            }
            elseif (empty($date)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The date is required
                </div>
                <?php
                
            }
            elseif (empty($category)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The category is required
                </div>
                <?php
                
            }
            elseif (empty($image)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    The image is required
                </div>
                <?php
                
            }
        }
       

?>

    <form method="POST" enctype="multipart/form-data">
        <label class="form">artist name</label>
        <input type="text" class="form-control custom" name="name"   value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>">
        <label class="form">description</label>
        <textarea class="form-control custom" name="description"><?php echo isset($_SESSION['description']) ? $_SESSION['description'] : '' ?></textarea>
        <label class="form">date of the event</label>
        <input type="date" class="form-control custom" name="date" value="<?php echo isset($_SESSION['date']) ? $_SESSION['date'] : '' ?>">
        <label class="form">Category</label>
        <select name="id_category" class="form-select custom-select">
            <option value="" disabled selected>Select ...</option>
            <option value="1" <?= (isset($_SESSION['id_category']) && $_SESSION['id_category'] == '1') ? 'selected' : '' ?>>Concert</option>
            <option value="2" <?= (isset($_SESSION['id_category']) && $_SESSION['id_category'] == '2') ? 'selected' : '' ?>>New Album</option>
            <option value="3" <?= (isset($_SESSION['id_category']) && $_SESSION['id_category'] == '3') ? 'selected' : '' ?>>Tour</option>
        </select>
        <label class="form">place</label>
        <input type="text" class="form-control custom" value="<?php echo isset($_SESSION['place']) ? $_SESSION['place'] : '' ?>" name="place">
        <label class="form">url</label>
        <textarea class="form-control custom" name="url"><?php echo isset($_SESSION['url']) ? $_SESSION['url'] : '' ?></textarea>
        <label class="form">Image</label>
        <input type="file" class="form-control custom" name="image" >    
        <input type="submit" value="add event" class="btn btn-custom my-2" name="add">
    </form>
</div>
</body>
</html>

