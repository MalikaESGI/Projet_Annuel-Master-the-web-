<?php
session_start();
require_once '../includes/connexion_bdd.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $get_id = $_GET['id'];
    $query = 'SELECT Article.*, User.username FROM Article INNER JOIN User ON `Article`.`User_id` = User.idUser WHERE Article.id = ?';
    $article = $bdd->prepare($query);
    $article->execute([$get_id]);

    if ($article->rowCount() > 0) {
        $article = $article->fetch();
        $title = $article['title'];
        $body = isset($article['body']) ? $article['body'] : '';
        $pubdate = date('Y-m-d', strtotime($article['date_of_publ']));
        $username = $article['username'];

        $isAuthor = false;
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $article['User_id']) {
            $isAuthor = true;
        }
    } else {
        die('This article does not exist!');
    }
} else {
    die('id not specified!');
}


if ($isAuthor && isset($_POST['delete_article'])) {
    
    $deleteQueryLike = 'DELETE FROM User_like_Article WHERE Article_id = ?';
    $deleteStmt = $bdd->prepare($deleteQueryLike);
    $deleteStmt->execute([$get_id]);

    $deleteQueryComment = 'DELETE FROM Comment WHERE Article_id = ?';
    $deleteStmt = $bdd->prepare($deleteQueryComment);
    $deleteStmt->execute([$get_id]);

    $deleteQuery = 'DELETE FROM Article WHERE id = ?';
    $deleteStmt = $bdd->prepare($deleteQuery);
    $deleteStmt->execute([$get_id]);
   
    header('Location: /read_article');
    exit;
}

$link = "../CSS/Style_read_more_article.css";
$titre = "Read Article";
$link2='';
$script='';
include '../includes/header_index.php';
?>
<div class="container mt-5 mb-5 p-5">
    <div class="clearfix">
        <h1 class="mb-5 mt-3 custom-h1"><?= $title ?></h1>
        <img src="/uploads/<?= $article['image'] ?>" class="col-md-6 float-md-end mb-3 ms-md-3" alt="Image de l'article">
        <p class="mb-5 mt-3 "><?= $body ?></p>
        <span><?= $username ?></span>
        <br>
        <span><?= $pubdate ?></span>
    </div>

    <?php if ($isAuthor) { ?>
        <form action="" method="POST">
            <input type="hidden" name="delete_article" value="1">
            <input type="submit" value="Delete article" style="background-color: #8E0808; color: white; border:none; border-radius:10px; padding:8px;">
        </form>
    <?php } ?>


        <?php
if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $articleId = $get_id;
    
    if (isset($_POST['user_like_article']) && isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $articleId= $get_id;

        $insertQuery = 'INSERT INTO User_like_Article (User_id, Article_id) VALUES (?, ?)';
        $insertStmt = $bdd->prepare($insertQuery);
        $insertStmt->execute([$userId, $articleId]);
        header('Location: /article_read_more?id=' . $get_id);
        exit;
    }
        $checkQuery = 'SELECT * FROM User_like_Article WHERE User_id = ? AND Article_id = ?';
        $checkStmt = $bdd->prepare($checkQuery);
        $checkStmt->execute([$userId, $articleId]);

        if ($checkStmt->rowCount() > 0) {
            echo '<p>You liked this article.</p>';
        } else {
       
    echo '<form action="" method="POST">
        <input type="hidden" name="user_like_article" value="1">
        <input type="submit" value="Like" style="background-color: #008000; color: white; border:none; border-radius:8px; padding:6px 20px;">
        </form>';
}
}
    ?>

</div>
<div class="container mt-5 mb-5 p-5">
    <div class="clearfix">

        <h1 class="mb-5 mt-3 custom-h1">Comment</h1>

        <form action="" method="POST">
            <div class="form_element my-4">
                <textarea type="text" class="form-control" name="text" placeholder="Your Comment"></textarea>
                <input type="hidden" name="article_id" value="<?= $get_id ?>">
            </div>

            <div class="form_element d-flex justify-content-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <input type="submit" value="Add comment" class="btn btn-custom mx-3">
                <?php else: ?>
                    <input type="submit" value="Add comment" class="btn btn-custom mx-3" disabled>
                    <?php
                    $loginURL = '/connexion?message=' . urlencode('You must log in to your account to be able to post a comment!');
                    echo '<p class="text-danger">You must log in to your account to be able to post a comment! Click <a href="' . $loginURL . '">here</a> to log in.</p>';
                    ?>
                <?php endif; ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['text'])) {
                        $text = trim($_POST['text']);
                        $userId = $_SESSION['user_id'];
                        $articleId = $get_id;

                        $commentInsertQuery = 'INSERT INTO Comment (text, date, User_id, Article_id) VALUES (?, NOW(), ?, ?)';
                        $commentInsertStmt = $bdd->prepare($commentInsertQuery);
                        $commentInsertStmt->execute([$text, $userId, $articleId]);

                        $success = 'Your comment has been successfully posted!';
                    } else {
                        $message = 'You must fill the field!';
                    }
                }
                ?>
            </div>
        </form>

        <?php
        $commentsQuery = 'SELECT Comment.*, User.username
                          FROM Comment
                          INNER JOIN User ON Comment.User_id = User.idUser
                          WHERE Comment.Article_id = ?';

        $commentsStmt = $bdd->prepare($commentsQuery);
        $commentsStmt->execute([$get_id]);

        while ($comment = $commentsStmt->fetch()) { ?>
            <div class="comment">
                <span><b><?= $comment['username'] ?></b></span>
                <span><?= $comment['date'] ?></span>
                <p><?= $comment['text'] ?></p>
            </div>
        <?php } ?>


        <?php if (!empty($message)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
<?php } ?>

<?php if (!empty($success)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success; ?>
    </div>
<?php } ?>

    </div>
</div>

</div>
<?php
include('../includes/footer.php');
?>