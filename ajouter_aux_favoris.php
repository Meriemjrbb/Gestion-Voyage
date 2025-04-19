<?php

include 'db_connect.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: authentification.php");
    exit();
}

if (isset($_GET['voyage_id'])) {
    $voyage_id = intval($_GET['voyage_id']);
    $user_id = $_SESSION['id'];

    // Requête pour insérer le voyage dans la table favoris
    $sql = "INSERT INTO favoris (user_id, voyage_id, date_ajout) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $voyage_id);

    if ($stmt->execute()) {
        header("Location: details_voyage.php?id=$voyage_id");
        exit();
    } else {

        echo "<p>Erreur lors de l'ajout aux favoris. Essayez de nouveau.</p>";
    }
} else {
    echo "<p>Voyage ou utilisateur non trouvé.</p>";
}
?>