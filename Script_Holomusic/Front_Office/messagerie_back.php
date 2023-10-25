<?php
session_start();
include "../includes/connexion_check.php";
include '../includes/connexion_bdd.php';
$q = 'SELECT conv.id AS ConvID, User1.idUser AS idUser1, User1.username AS username1, User2.idUser AS
        idUser2, User2.username AS username2 FROM (SELECT id, id_User1, id_User2 FROM Conversation) AS conv 
        JOIN User AS User1 ON conv.id_User1 = User1.idUser JOIN User AS User2 ON conv.id_User2 = User2.idUser 
        WHERE User1.idUser = ? OR User2.idUser = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$donnee = $req->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($donnee);

//SELECT DISTINCT u1.idUser AS sender_id,u1.username AS sender_username,
//                    u2.idUser AS reciever_id,u2.username AS reciever_username FROM Message m
//                    JOIN User u1 ON m.User_id_Sender = u1.idUser
//                    JOIN User u2 ON m.User_id_Reciever = u2.idUser WHERE
//                    m.User_id_Sender = 10 OR m.User_id_Reciever = 10