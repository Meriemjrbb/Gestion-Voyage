<?php

include 'db_connect.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: authentification.php");
    exit();
}

// Vérifier si un ID de voyage est passé 
if (isset($_GET['voyage_id'])) {
    $voyage_id = intval($_GET['voyage_id']); // Transformer cette valeur en entier
    $user_id = $_SESSION['id']; // Récupérer l'ID de l'utilisateur depuis la session


    $sql = "DELETE FROM favoris WHERE user_id = ? AND voyage_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $voyage_id);

    if ($stmt->execute()) {
        // Rediriger vers la page précédente
        $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirect_url");
        exit();
    } else {

        echo "<p>Erreur lors de la suppression du favori. Veuillez réessayer.</p>";
    }
} else {

    echo "<p>Action non autorisée.</p>";
}
?>