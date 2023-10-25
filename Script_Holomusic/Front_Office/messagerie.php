<?php
session_start();
$link = "../CSS/style_messagerie.css";
$link2 = "";
$script = "../JS/ConversationSearch.js";
$titre = "Messagerie";
include '../includes/header_index.php';
include '../includes/connexion_check.php';
include '../includes/connexion_bdd.php';

if (isset($_POST['message']) && !empty($_POST['message'])) {
    $q = 'INSERT INTO Message (User_id_Sender, User_id_Reciever,Text) VALUES (?,?,?)';
    $req = $bdd->prepare($q);
    $req->execute([$_SESSION['user_id'], 1, $_POST['Message']]);
}
?>
<div id="newConv" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="subNewConvForm" action="" method="POST">
            <div class="quiz">
                <h1 id="quiz">New Conversation</h1>
                <input type="text" id="usernameInput" placeholder="Username">
                <textarea name="message" id="NewmessageInput" cols="90" rows="3" placeholder="Écrivez votre message ici..." value=required></textarea>
                <input type="submit" id="submitBtn">Envoyé</button>
            </div>
        </form>


    </div>
</div>

<div class="container border border-secondary mt-5">
    <div style="height: 500px" class="row">
        <div class="ps-5 p-3 col-4 border-end" id="conversations" style="overflow-y: scroll; overflow-x: hidden">
            <table style="width: 100%;" class="table border border-0">
                <thead>
                    <div class="row border-bottom pb-2  me-3">
                        <h2 class=" col-10 ">Conversation</h2>
                        <a id="addConv" class=" col-2 btn btn-danger btn-custom rounded-pill" href="#">+</a>
                    </div>
                </thead>
                <tbody class="text-center" id="searchResultsConversation">
                </tbody>
            </table>
        </div>
        <div class="col-8 " id="messages">
            <div>
                <table id="afficheMessage" class="table table-striped-columns text-center">
                    <thead id="searchResultsConversationHead" s>

                    </thead>
                    <tbody id="searchResultsMessage">

                    </tbody>
                </table>
            </div>
            <div class="row p-2 g-3 align-items-center border-top">

                <form class="row" id="myForm">
                    <textarea class="col-10" name="message" id="messageInput" cols="90" rows="3" placeholder="Écrivez votre message ici..." required></textarea>
                    <button class="btn btn-danger col-1 p-1 m-3" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>