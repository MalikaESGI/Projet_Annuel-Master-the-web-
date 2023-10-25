<?php
session_start();
require_once '../includes/connexion_bdd.php';
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location: /connexion?message=You must log in to your account in order to post your article!');
    exit;
    
}

require '/var/www/html/PHP_MAILER/src/Exception.php';
require '/var/www/html/PHP_MAILER/src/PHPMailer.php';
require '/var/www/html/PHP_MAILER/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$message = '';
$error = '';

if (isset($_POST['title']) && isset($_POST['body']) && isset($_FILES['image'])) {
    if (!empty($_POST['title']) && !empty($_POST['body'])) {
        $title = trim($_POST['title']);
        $title = htmlspecialchars($title);
        $body = trim($_POST['body']);
        $body = htmlspecialchars($body);
        
        $expiry = time() + (2 * 60);
        setcookie('title', $title, $expiry);
        setcookie('body', $body, $expiry);

        $userId = $_SESSION['user_id'];

        $category = $_POST['category'];

        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $erreur = $_FILES['image']['error'];

        if ($erreur === 0) {
            $maxSize = 2 * 1024 * 1024;
            if ($img_size > $maxSize) {
                $error = "Sorry, your file is too large.";
                header("Location: /article_post?error=" . urlencode($error));
                exit;
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "gif");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '/var/www/html/uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    $error = "You can't upload files of this type";
                    header("Location: /article_post?error=" . urlencode($error));
                    exit;
                }
            }
        } else {

            $error = "Error uploading the file.";
            header("Location: /article_post?error=" . urlencode($error));
            exit;
        }

        $articleInsertQuery = 'INSERT INTO Article (title, body, date_of_publ, image, User_id, Category_id) VALUES (?, ?, NOW(), ?, ?, ? )';
        $articleInsertStmt = $bdd->prepare($articleInsertQuery);
        $articleInsertStmt->execute(array($title, $body, $new_img_name, $userId,$category));

        
        $newsletterQuery = 'SELECT User.email FROM Newsletter JOIN User ON User.idUser = Newsletter.User_idUser';
        $newsletterStmt = $bdd->prepare($newsletterQuery);
        $newsletterStmt->execute();
        $subscribers = $newsletterStmt->fetchAll(PDO::FETCH_COLUMN);

        if ($subscribers) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'patate.O2switch.net';
                $mail->SMTPAuth = true;
                if ($mail->SMTPAuth) {
                    $mail->SMTPSecure = 'ssl';
                    $mail->Username = 'derradji.ines@bessah.com';
                    $mail->Password = 'P@ssword2023';
                }
                $mail->Port = 465;

                $mail->setFrom('derradji.ines@bessah.com', 'HOLOMUSIC');

                foreach ($subscribers as $subscriber) {
                    $email = strval($subscriber);
                    $mail->addAddress($email);
                }

                $mail->isHTML(true);
                $mail->Subject = 'New article published!';
                $mail->Body = ' Dear subscriber,<br>
                We are excited to share that a new article has just been published !!! <br>
                Stay informed and inspired by visiting our website and checking out the new article today!
                ';

                $mail->AltBody = 'News';

                $mail->send();
            } catch (Exception $e) {
                
            }
        }
        $message = 'Your article has been successfully posted!';
    } else {
        $error = 'You must fill all fields!';
    }
}

$link = "../CSS/Style_article_post.css";
$titre = "Article Publication";
$link='';
$link2='';
$script='';
include '../includes/header_index.php';
?>
<div class="container article_container py-5">
    <h1 class="d-flex justify-content-between my-4">Create New Topic</h1>

    <form action="/article_post" method="POST" enctype="multipart/form-data">
       
<div class="form_element my-4">
    <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo isset($_COOKIE['title']) ? $_COOKIE['title'] : ''; ?>">
</div>

<div class="form_element my-4">
    <textarea type="text" class="form-control" name="body" placeholder="Content"><?php echo isset($_COOKIE['body']) ? $_COOKIE['body'] : ''; ?></textarea>
</div>
        <div class="form_element my-4">
            <label for="catego" style="color: white">Category</label>
            <select name="category" id="catego" class="form-select custom-select">
                <?php
                $q = 'Select * From Category';
                $req = $bdd->prepare($q);
                $req->execute([]);
                $donnee = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($donnee as $Index => $Value) {
                    echo '<option value="' . $Value['id'] . '">' . $Value['name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form_element my-4 ">
            <input class="form-control" type="file" name="image">
        </div>
        <div class="form_element d-flex justify-content-center">
            <input type="submit" value="Add article" class="btn btn-danger  m-3 ">

        </div>
    </form>


<?php if (!empty($message)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>
</div>

<?php
include('../includes/footer.php');
?>
</body>
</html>
