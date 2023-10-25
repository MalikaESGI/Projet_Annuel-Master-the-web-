<?php
session_start();
include '../includes/connexion_check.php';


$titre = 'Events';
$link = '../CSS/style_event_detail.css';
$link2 = '';
$script = '';
include '../includes/header_index.php';
include '../includes/connexion_bdd.php';

$id = $_GET['id'];

$sqlState = $bdd->prepare("SELECT * FROM Event WHERE id=?");
$sqlState->execute([$id]);
$event = $sqlState->fetch(PDO::FETCH_ASSOC);
?>
<div class="container py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="img img-fluid w-75" src="../uploads/<?php echo $event['image'] ?>" alt="<?php echo $event['name'] ?>">
            </div>
            <div class="col-md-6 details">
                <div class="d-flex align-items-center">
                    <h1 class="w-100"><?php echo $event['name'] ?></h1>
                </div>
                <br>
                <p class="text-justify">
                    <?php echo $event['description'] ?>
                </p>
                <?php
                $idevent = $event['id'];
                ?>
                <div class="d-flex align-items-center">
                    <h8 class="w-100"><?php echo $event['date'] ?></h8>
                </div>
                <div class="d-flex align-items-center">
                    <h8 class="w-100"><?php echo $event['place'] ?></h8>
                </div>
                <form method="POST" action="/click_event">
                    <input type="hidden" class="form-control" name="id" value="<?php echo $event['id'] ?>">
                    <input type="submit" value="Visit now" class="btn custom-btn-cart my-2" name="Visit now">
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>