<?php
session_start();
include '../includes/connexion_bdd.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id']; 

        $stmt = $bdd->prepare('SELECT url FROM Events WHERE id = ?');
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        $url = $event['url']; 

        $user_id = $_SESSION['user_id'];

        $stmt = $bdd->prepare('INSERT INTO User_Engage_Event(Event_id, User_id) VALUES (:event_id, :user_id)');
        $stmt->execute([':event_id' => $id, ':user_id' => $user_id]);

        header('Location: '. $url);
        exit;
    } else {
        echo "File not found.";
    }
}
?>
