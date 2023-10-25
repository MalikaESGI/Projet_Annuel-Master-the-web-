<?php
include '../includes/connexion_bdd.php';
if (isset($_REQUEST['text']) && isset($_REQUEST['Sender']) && isset($_REQUEST['Reciever']) && isset($_REQUEST['Conversation'])) {
    $text = $_REQUEST['text'];
    $sender = $_REQUEST['Sender'];
    $receiverName = $_REQUEST['Reciever'];
    $conversation = $_REQUEST['Conversation'];

    $query = $bdd->prepare("SELECT idUser FROM User WHERE username = :username");
    $query->bindParam(':username', $receiverName);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $receiverId = $user['idUser'];
        $query = $bdd->prepare("INSERT INTO Message (text, User_id_Sender, User_id_Reciever, ConversationID) 
                                        VALUES (:text, :sender, :reciever, :conversation)");
        $query->bindParam('text', $text);
        $query->bindParam('sender', $sender);
        $query->bindParam('reciever', $receiverId);
        $query->bindParam('conversation', $conversation);
        $query->execute();
    } else {
        echo "Aucun utilisateur correspondant trouvé.";
    }
} else {
    echo "La clé 'text', 'Sender', 'Reciever' ou 'Conversation' n'existe pas dans le tableau \$_REQUEST.";
}
