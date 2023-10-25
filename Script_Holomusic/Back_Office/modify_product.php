<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Edit products';
$link = '../CSS/style_back_officeM.css';
include '../includes/header_backoffice.php';
include '../includes/connexion_bdd.php';
?>
<div class="container py-2">
    <h4>Edit products</h4>
    <?php

    $id = $_GET['id'];
    $sqlState = $bdd->prepare('SELECT * FROM Products WHERE id=?');
    $sqlState->execute([$id]);
    $product = $sqlState->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['modify'])) {
        $name = trim($_POST['name']);
        $price = $_POST['price'];
        $Description = trim($_POST['Description']);
        $discount = $_POST['discount'];

        $image = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            $maxSize = 2 * 1024 * 1024;
            if ($img_size > $maxSize) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Sorry, your file is too large.
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
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        You can't upload files of this type
                    </div>
                    <?php
                }
            }
        } else {
            $image = $product['image'];
        }

        if (!empty($name) && !empty($price) &&  !empty($Description) && !empty($image)) {
            $sqlState = $bdd->prepare('UPDATE  Products 
                                             SET name = ? ,
                                             price = ?,
                                             Description = ? ,
                                             discount = ?,
                                             image = ?
                                            
                                             WHERE id = ?;
                                                ');
            $sqlState->execute([htmlspecialchars($name), htmlspecialchars($price),htmlspecialchars($Description) , htmlspecialchars($discount), $image, htmlspecialchars($id)]);
            header('location: /admin/product_list');
            exit;
             
        } elseif(empty($name)) {
            ?>
            <div class="alert alert-danger" role="alert">
                the name is required
            </div>
            <?php
            }
            elseif(empty($price)) {
            ?>
            <div class="alert alert-danger" role="alert">
                the price is required
            </div>
            <?php
            }
            elseif(empty($Description)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    the description is required
                </div>
                <?php
                }        
            elseif(empty($image)) {
            ?>
            <div class="alert alert-danger" role="alert">
                the image is required
            </div>
            <?php
            }  
                  
        }
    
    ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="id" value="<?php echo $product['id'] ?>">
        <label class="form-label">name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $product['name'] ?>">
        <label class="form-label">Price</label>
        <input type="number" step="0.1" class="form-control" name="price" min="1" value="<?php echo $product['price'] ?>">
        <label class="form">Description</label>
        <textarea class="form-control" name="Description"><?php echo $product['Description'] ?></textarea>
        <label class="form">discount</label>
        <input type="range" value="0" class="form-control custom"  id="discount" name="discount" min="0" max="90" value="<?php echo $product['discount'] ?>">
        <span id="value">0</span>%
        <br>
        <label class="form">Image</label>
        <input type="file" class="form-control custom" name="image">
        <input type="submit" value="modify" class="btn btn-custom  my-4" name="modify">
        </form>
       <script>

    const range = document.getElementById('discount');
    const value = document.getElementById('value');

    
    value.textContent = range.value;

   
    range.addEventListener('input', function() {
        value.textContent = range.value;
    });
</script>
</div>
</body>
</html>
