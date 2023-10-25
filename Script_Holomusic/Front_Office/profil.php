<?php
session_start();
include '../includes/connexion_check.php';
$link = '';
$script = "../JS/profil_avatar.js";
$titre = 'Profil';
include '../includes/header_index.php';
include '../includes/connexion_bdd.php';
?>

<div class="container">
    <div class="row pt-5 text-center">
        <div class="col-6 avatar text-center position-relative">

            <!--avatar-->
            <img id="visage1" class="visage col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/visage1.png" style="display: none; z-index: 0;" alt="Image Avatar">
            <img id="visage2" class="visage col-12" src="../asset/assetAvatar/visage2.png" style="display: none; z-index: 0;" alt="Image Avatar">

            <!--cheveux-->
            <img id="cheveux1" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux1.png" style="display: none;
                     z-index: 2;" alt="Image Avatar">
            <img id="cheveux2" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux2.png" style="display: none;
                     z-index: 2;" alt="Image Avatar">
            <img id="cheveux3" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux3.png" style="display: none;
                     z-index: 2;" alt="Image Avatar">
            <img id="cheveux4" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux4.png" style="display: none;
                    top: 50px; left: 380px; z-index: 2;" alt="Image Avatar">
            <img id="cheveux5" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux5.png" style="display: none;
                     z-index: 2;" alt="Image Avatar">
            <img id="cheveux6" class="cheveux col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/cheveux6.png" style="display: none;
                     z-index: 2;" alt="Image Avatar">

            <!--oeil-->
            <img id="oeil1" class="oeil col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/oeil1.png" style="display: none;
                     z-index: 3;" alt="Image Avatar">
            <img id="oeil2" class="oeil col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/oeil2.png" style="display: none;
                     z-index: 3;" alt="Image Avatar">
            <img id="oeil3" class="oeil col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/oeil3.png" style="display: none;
                     z-index: 3;" alt="Image Avatar">
            <img id="oeil4" class="oeil col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/oeil4.png" style="display: none;
                     z-index: 3;" alt="Image Avatar">

            <!--barbes-->
            <img id="barbe2" class="barbe col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/barbe2.png" style="display: none;
                    top:110px; left: 380px; z-index: 1;" alt="Image Avatar">
            <img id="barbe1" class="barbe col-12 position-absolute top-0 start-0" src="../asset/assetAvatar/barbe1.png" style="display: none;
                    top:110px; left: 380px; z-index: 1;" alt="Image Avatar">

        </div>
        <div class="col-6" id="avatar">
            <div>
                <h3 class="">Cheveux</h3>
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux1.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux2.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux3.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux4.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux5.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/cheveux6.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
            </div>

            <div class="pt-1">
                <h3 class="">Visages</h3>
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/visage1.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/visage2.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
            </div>
            <div class="pt-1">
                <h3 class="">Barbes</h3>
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/barbe1.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/barbe2.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <!--visage-->
            </div>
            <div class="pt-1">
                <h3 class="">Yeux</h3>
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/oeil2.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
                <img draggable="true" class="draggable col-1" src="../asset/assetAvatar/oeil3.png" width="50px" height="50px" style="background-color:white; border: white solid 1px" alt="Image Avatar">
            </div>
        </div>
        <div class="text-center offset-2 pt-5">
            <input type="button" id="saveB" value="Enregistrer">
            <input type="button" id="changeB" value="Changer">
        </div>
    </div>
</div>
<?php
$q = 'SELECT name,firstname,birthdate,username,email,image,bio,avatar FROM User WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['email']]);
$donnee = $req->fetchAll(PDO::FETCH_ASSOC);

foreach ($donnee as $item => $value) {
    echo   '<div style="margin-top: 100px" class="container">
            <form action="/verification_modif_profilUser" method="POST" enctype="multipart/form-data">
                <div class="row">
                <div class="col-5">
                <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Username</label>
                        <input type="text" class="form-control custom" name="username" value="' . ($value['username']) . '">
                    </div>
                    </div>
                    <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Name</label>
                        <input type="text" class="form-control custom" name="name" value="' . ($value['name']) . '">
                    </div>
                </div>
                <div class="row">
            
                    <div class="offset-1 pb-3">
                        <label class="form">First Name</label>
                        <input type="text" class="form-control custom" name="firstname" value="' . ($value['firstname']) . '">
                    </div>
                    </div>
                    <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Password</label>
                        <input type="text" class="form-control custom" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Email</label>
                        <input type="text" class="form-control custom" name="email" value="' . ($value['email']) . '">
                    </div>
                </div>
                <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Biographie</label>
                        <input type="text" class="form-control custom" name="bio" value="' . ($value['bio']) . '">
                    </div>
                </div>
                <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Profil Picture</label>
                        <img src="' . ($value['image']) . '" alt="Image de Profil">
                    </div>
                    </div>
                    <div class="row">
                    <div class="offset-1 pb-3">
                        <label class="form">Profil Picture</label>
                        <input type="image" class="form-control custom" name="Image" accept="image/png,image/jpg,image/jpeg,image/gif">
                    </div>
                </div>
                
                <input type="submit" value="Modify" class="btn btn-danger btn-custom offset-1 my-4">
                </div>
            
                
                </div>
            </form>
        </div>
        <br/>
        <div class="offset-3 pb-5">
            <a href="/sendPDF" class="btn btn-primary">Recover your personnal data</a>
        </div>';
}


include '../includes/footer.php';
?>