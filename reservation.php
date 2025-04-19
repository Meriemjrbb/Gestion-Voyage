<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['id'])) {
    header("Location: authentification.php");
    exit();
}


if (isset($_GET['voyage_id'])) {
    $voyage_id = intval($_GET['voyage_id']);

    //les détails du voyage et la catégorie
    $sql = "SELECT v.*, c.nom AS categorie_nom 
            FROM voyages v 
            JOIN categories c ON v.categorie_id = c.id
            WHERE v.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $voyage_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si le voyage existe
    if ($result->num_rows > 0) {
        $voyage = $result->fetch_assoc();
    } else {
        echo "<p>Voyage non trouvé !</p>";
        exit();
    }
} else {
    echo "<p>Aucun voyage sélectionné.</p>";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id']; // l'ID de l'utilisateur connecté
    $voyage_id = $voyage['id'];
    $nombre_places = intval($_POST['nombre_places']);

    // Vérifier si le nombre de places demandées est disponible
    if ($nombre_places > $voyage['places_disponibles']) {
        $error_message = "Désolé, il n'y a pas assez de places disponibles.";
    } else {
        // Insérer la réservation dans la base de données
        $sql_reservation = "INSERT INTO reservations (user_id, voyage_id, nb_places_reserv) VALUES (?, ?, ?)";
        $stmt_reservation = $conn->prepare($sql_reservation);
        $stmt_reservation->bind_param("sii", $user_id, $voyage_id, $nombre_places);
        if ($stmt_reservation->execute()) {
            // Mettre à jour les places disponibles
            $new_places = $voyage['places_disponibles'] - $nombre_places;
            $sql_update = "UPDATE voyages SET places_disponibles = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $new_places, $voyage_id);
            $stmt_update->execute();

            // Récupérer les nouvelles données du voyage après mise à jour
            $stmt->execute();
            $result = $stmt->get_result();
            $voyage = $result->fetch_assoc();

            $nombre_places = 0;
            $success_message = "Réservation réussie !";
        } else {
            $error_message = "Erreur lors de la réservation, veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Gestion Voyages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .reservation-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-reservation {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-reservation:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="reservation-container">
        <h1>Réservation du voyage : <?= $voyage['titre']; ?></h1>

        <!-- Afficher les messages d'erreur ou de succès -->
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message; ?>
            </div>
        <?php } ?>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $success_message; ?>
            </div>
        <?php } ?>

        <p><strong>Catégorie : </strong><?= $voyage['categorie_nom']; ?></p>
        <img src="images/<?= $voyage['image']; ?>" alt="<?= $voyage['titre']; ?>" class="img-fluid">
        <p><strong>Prix : </strong><?= $voyage['prix']; ?> DT</p>
        <p><strong>Places disponibles : </strong><?= $voyage['places_disponibles']; ?></p>

        <form action="reservation.php?voyage_id=<?= $voyage['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="nombre_places" class="form-label">Nombre de places</label>
                <input type="number" class="form-control" id="nombre_places" name="nombre_places"
                    max="<?= $voyage['places_disponibles']; ?>" value="" required>

            </div>

            <button type="submit" class="btn-reservation">Confirmer la réservation</button>
        </form>
        <a href="details_voyage.php?id=<?= $voyage['id']; ?>" class="btn btn-secondary mt-3">Retour</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>