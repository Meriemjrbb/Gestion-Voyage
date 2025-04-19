<?php
include('db_connect.php');
session_start();
if (isset($_POST['message']) && isset($_SESSION['id'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['id'];

    // Insérer le témoignage dans la base de données
    $stmt = $conn->prepare("INSERT INTO testimonials (  message, id_user) VALUES (?, ?)");
    $stmt->bind_param("si", $message, $user_id);

    if ($stmt->execute()) {
        // Rediriger vers la page d'accueil ou la section des témoignages
        header('Location: index.php#testimonials');
    } else {
        echo "Erreur lors de l'ajout du témoignage.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Veuillez vous connecter pour ajouter un témoignage.";
}
?>