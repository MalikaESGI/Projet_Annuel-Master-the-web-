<?php
session_start();

// Vérifiez si l'utilisateur est connecté et récupérez l'ID de l'utilisateur à partir de la session
if (isset($_SESSION['user_id']) && isset($_FILES['image'])) {
    $idUser = $_SESSION['user_id'];
  
    // Obtenez le nom du fichier à partir des données du fichier téléchargé
    $fileName = $_FILES['image']['name'];

    // Spécifiez le chemin où vous souhaitez enregistrer l'image
    $filePath = '/var/www/html/uploads/avatar/' . $fileName;
  
    // Déplacez l'image téléchargée vers l'emplacement souhaité
    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        // Enregistrez le chemin de l'image dans la base de données pour l'utilisateur actuel
        // Vous devrez adapter le code suivant pour votre propre configuration de base de données
        include '../includes/connexion_bdd.php';
        $stmt = $bdd->prepare('UPDATE User SET avatar = :avatar WHERE idUser = :id');
        $stmt->bindParam(':avatar', $fileName);
        $stmt->bindParam(':id', $idUser);
        $stmt->execute();

        echo 'OK';
    } else {
        echo 'Erreur lors de l\'enregistrement de l\'image.';
    }
} else {
    echo 'Utilisateur non connecté.';
}