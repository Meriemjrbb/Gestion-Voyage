<?php

include 'db_connect.php';

// Vérifier si un ID est passé 
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour supprimer l'avis
    $query = "DELETE FROM testimonials WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            
            header("Location: admin.php?section=avis");
            exit;
        } else {
            echo "Erreur lors de la suppression de l'avis.";
        }
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Aucun ID spécifié pour la suppression.";
}
?>