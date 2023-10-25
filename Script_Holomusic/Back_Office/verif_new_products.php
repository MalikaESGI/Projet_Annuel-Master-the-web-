<?php
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check_admin.php';
function save($name, $price, $description, $discount) {
    $_SESSION['name'] = $name;
    $_SESSION['price'] = $price;
    $_SESSION['description'] = $description;
    $_SESSION['discount'] = $discount;
}

function clear() {
    unset($_SESSION['name']);
    unset($_SESSION['price']);
    unset($_SESSION['description']);
    unset($_SESSION['discount']);
}

if (isset($_POST['name'])&&isset($_POST['price'])&&isset($_POST['description'])&&isset($_POST['discount'])) {  
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = trim ($_POST['description']);
    $discount = $_POST['discount'];

    save($name, $price, $description, $discount);

    $image = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];

    if ($error === 0) {
        $maxSize = 2 * 1024 * 1024;
        if ($img_size > $maxSize) {
            
            header('location: /admin/add_products?message=Sorry, your file is too large.&type=danger');
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
                header('location: /admin/add_products?message=You can\'t upload files of this type.&type=danger');
                exit;
            }
        }
    }

    if (!empty($name) &&  !empty($price) &&  !empty($description) && !empty($image)) {
        $sqlState = $bdd->prepare('INSERT INTO Products (name,price,Description,discount,image,date) VALUES (?,?,?,?,?,?)');
        $date=date('Y-m-d');
        $sqlState->execute([htmlspecialchars($name), htmlspecialchars($price),htmlspecialchars($description) ,$discount, $img_upload_path,$date]);
        clear();
        header('location: /admin/product_list?message='.$name.' is added succefuly.&type=success');   
        exit;
    } 
    elseif(empty($name)){
        header('location: /admin/add_products?message=The name is required.&type=danger');
        exit;
    }
    elseif(empty($price)){
        header('location: /admin/add_products?message=The price is required.&type=danger');
        exit;
    }
    elseif(empty($description)){
        header('location: /admin/add_products?message=The description is required.&type=danger');
        exit;
    }
    elseif(empty($image)){
        header('location: /admin/add_products?message=The image is required.&type=danger');
        exit;
    }
}