<?php
include '../includes/connexion_bdd.php';

if (isset($_REQUEST['text']) && isset($_REQUEST['Sender']) && isset($_REQUEST['Reciever'])) {
    $text = $_REQUEST['text'];
    $sender = $_REQUEST['Sender'];
    $receiverName = $_REQUEST['Reciever'];

    $query = $bdd->prepare("SELECT idUser FROM User WHERE username = :username");
    $query->bindParam(':username', $receiverName);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $receiverId = $user['idUser'];

        $query = $bdd->prepare("SELECT * FROM Conversation WHERE (id_User1 = :sender AND id_User2 = :reciever) OR (id_User1 = :reciever2 AND id_User2 = :sender2)");
        $query->bindParam(':sender', $sender);
        $query->bindParam(':reciever', $receiverId);
        $query->bindParam(':reciever2', $receiverId);
        $query->bindParam(':sender2', $sender);
        $query->execute();
        $conversation = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$conversation) {
            $queryNewConv = $bdd->prepare("INSERT INTO Conversation (id_User1,id_User2) VALUES (:sender, :reciever)");
            $queryNewConv->bindParam(':sender', $sender);
            $queryNewConv->bindParam(':reciever', $receiverId);
            $queryNewConv->execute();

            $queryGetConv = $bdd->prepare("SELECT id FROM Conversation WHERE id = LAST_INSERT_ID()");
            $queryGetConv->execute();
            $donnee = $queryGetConv->fetch(PDO::FETCH_ASSOC);

            $query = $bdd->prepare("INSERT INTO Message (text, User_id_Sender, User_id_Reciever, ConversationID) 
        VALUES (:text, :sender, :reciever, :conversation)");
            $query->bindParam(':text', $text);
            $query->bindParam(':sender', $sender);
            $query->bindParam(':reciever', $receiverId);
            $query->bindParam(':conversation', $donnee['id']);
            $query->execute();
        } else {
            //header('location: /messagerie?message=Vous avez deja une conversation avec cet utilisateur');
            exit;
        }
    } else {
        echo "Aucun utilisateur correspondant trouvé.";
    }
} else {
    echo "La clé 'text' n'existe pas dans le tableau \$_REQUEST.";
}
