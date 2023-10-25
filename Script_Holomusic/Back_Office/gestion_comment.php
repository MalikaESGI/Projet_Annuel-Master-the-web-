<?php
session_start();

include '../includes/connexion_check_admin.php';
include '../includes/connexion_bdd.php';

if (isset($_GET['recent'])) {
    $threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
    $query = 'SELECT Comment.id, Comment.User_id, Comment.date, Comment.Article_id, Article.title, User.username
              FROM Comment 
              JOIN Article ON Comment.Article_id = Article.id 
              JOIN User ON Comment.User_id = User.idUser
              WHERE Comment.date >= "' . $threeMonthsAgo . '" 
              ORDER BY Comment.id DESC';
} else {
    $query = 'SELECT Comment.id, Comment.User_id, Comment.date, Comment.Article_id, Article.title, User.username
              FROM Comment 
              JOIN Article ON Comment.Article_id = Article.id 
              JOIN User ON Comment.User_id = User.idUser
              ORDER BY Comment.id DESC';
}


$result = $bdd->query($query);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);

 
    $checkQuery = 'SELECT id FROM Comment WHERE id = ?';
    $checkStmt = $bdd->prepare($checkQuery);
    $checkStmt->execute([$get_id]);
    $commentExists = $checkStmt->rowCount() > 0;

    if ($commentExists) {
      
        $deleteQuery = 'DELETE FROM Comment WHERE id = ?';
        $deleteStmt = $bdd->prepare($deleteQuery);
        $deleteStmt->execute([$get_id]);
        $message = 'Comment deleted successfully!';
    }
}
$link = '../CSS/Style_gestion_article.css';
$script = '';
$titre = 'Comment Management';
include '../includes/header_backoffice.php'; 

?>

<div class="container">
    <header></header>
    <div class="d-md-flex justify-content-between align-items-center my-5">
        <h1 class="mb-3 mb-md-0">Comment</h1>
        <div class="order-md-1">
            <form method="GET" action="" class="row align-items-center">
                <div class="col-auto">
                    <button class="btn custom-button" type="submit" name="recent" value="1">Recent Comment</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-striped table-success">
        <thead>
        <tr>
            <th>Id</th>
            <th>User id</th>
			 <th>Username</th>
            <th>Date of Publication</th>
            <th>Article Title</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo isset($row["User_id"]) ? $row["User_id"] : ""; ?></td>
					<td><?php echo isset($row["username"]) ? $row["username"] : ""; ?></td>

                    <td><?php echo isset($row["date"]) ? $row["date"] : ""; ?></td>
                    <td><?php echo isset($row["title"]) ? $row["title"] : ""; ?></td>
                    <td>
                        <a href="/article_read_more?id=<?php echo $row["Article_id"]; ?>" class="btn btn-sm btn-info ">Read More</a>
                        <a href="/admin/gestion_comment?id=<?php echo $row["id"]; ?>"
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6">No comments found.</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <?php if (!empty($message)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $message; ?>
    </div>
<?php } ?>



</div>
</body>
</html>
