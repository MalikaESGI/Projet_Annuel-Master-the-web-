<?php
session_start();
include '../includes/connexion_bdd.php';
$event = $bdd->query('SELECT Event.*, Event_Category.name AS category FROM Event
                        JOIN Event_Category ON Event.id_category = Event_Category.id');
$titre = 'Events';
$link = '../CSS/style_footer.css';
$link2 = '../CSS/event.css';
include '../includes/header_index.php';
?>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md">
            </div>
            <div class="d-md-flex justify-content-between align-items-center my-5">
                <h1 class="mb-3 mb-md-0 text ">Don't miss out on the ultimate music experiences: <br>Discover the latest and upcoming <span class="text-custom"> stellar </span> events !</h1>
            </div>
            <section id="Concert" class="mt-5 mb-5" id="eventTableBody">
                <h2 class="mb-5 p-2 custom-h2">Concert</h2>
                <div class="row">
                    <?php while ($events = $event->fetch()) {
                        if ($events['category'] == 'Concert') { ?>
                            <div class="col-md-4 text-center">
                                <div class="card mb-5" style="width: 20rem;">
                                    <img src="../uploads/<?= $events['image'] ?>" class="card-img-top " alt="Article Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= strtoupper($events['name']) ?></h5>
                                        <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $events['description'] ?></p>
                                        <p class="card-text"> <?= date('Y-m-d', strtotime($events['date'])) ?></p>
                                        <a href="/events_details?id=<?php echo $events['id']?>" class="btn btn-custom mt-3 mb-3">See more</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
            <section id="Album" class="mt-5 mb-5" id="eventTableBody">
                <h2 class="mb-5 p-2 custom-h2 ">Album</h2>
                <div class="row">
                    <?php $event->execute(); ?>
                    <?php while ($events = $event->fetch()) { ?>
                        <?php if ($events['category'] == 'Album') { ?>
                            <div class="col-md-4">
                                <div class="card mb-5" style="width: 20rem;">
                                    <img src="../uploads/<?= $events['image'] ?>" class="card-img-top" alt="Article Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $events['name'] ?></h5>
                                        <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $events['description'] ?></p>
                                        <p class="card-text"><?= date('Y-m-d', strtotime($events['date'])) ?></p>
                                        <a href="/events_details?id=<?php echo $events['id']?>" class="btn btn-custom mt-3 mb-3">See more</a>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
            <section id="Tour" class="mt-5" id="eventTableBody">
                <h2 class="mb-5 p-2 custom-h2">Tour</h2>
                <div class="row">
                    <?php $event->execute(); ?>
                    <?php while ($events = $event->fetch()) { ?>
                        <?php if ($events['category'] == 'tour') { ?>
                            <div class="col-md-4">
                                <div class="card mb-5" style="width: 20rem;">
                                    <img src="../uploads/<?= $events['image'] ?>" class="card-img-top" alt="Article Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $events['name'] ?></h5>
                                        <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $events['description'] ?></p>
                                        <p class="card-text"><?= date('Y-m-d', strtotime($events['date'])) ?></p>
                                        <a href="/events_details?id=<?php echo $events['id']?>" class="btn btn-custom mt-3 mb-3">See more</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
    </div>
   
</body>
<?php
include '../includes/footer.php';
?>

</html>