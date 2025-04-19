<?php

include 'db_connect.php';

// Vérifier si un ID est passé 
if (isset($_GET['id'])) {
    $voyage_id = intval($_GET['id']); // transformer cette valeur en un entier pour éviter des erreurs ou des injections

    // Requête pour récupérer les détails du voyage MEME SI IL N'ya pas de catégorie
    $sql = "SELECT v.*, c.nom AS categorie 
            FROM voyages v
            LEFT JOIN categories c ON v.categorie_id = c.id
            WHERE v.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $voyage_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si un voyage a été trouvé
    if ($result->num_rows > 0) {
        $voyage = $result->fetch_assoc();
    } else {
        echo "<p>Voyage non trouvé !</p>";
        exit;
    }

    // Vérifier si ce voyage est en promotion
    $sql_promotion = "SELECT * FROM promotions 
                       WHERE voyage_id = ? AND CURRENT_DATE < date_fin";
    $stmt_promotion = $conn->prepare($sql_promotion);
    $stmt_promotion->bind_param("i", $voyage_id);
    $stmt_promotion->execute();
    $result_promotion = $stmt_promotion->get_result();

    if ($result_promotion->num_rows > 0) {
        $promotion = $result_promotion->fetch_assoc();
        $is_on_promotion = true;
        $prix_reduit = $voyage['prix'] - ($voyage['prix'] * $promotion['pourcentage_reduction'] / 100);
    } else {
        $is_on_promotion = false;
    }

    // Vérifier si le voyage est déjà dans les favoris de l'utilisateur
    session_start(); 
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];

        $sql_favoris = "SELECT * FROM favoris WHERE user_id = ? AND voyage_id = ?";
        $stmt_favoris = $conn->prepare($sql_favoris);
        $stmt_favoris->bind_param("ii", $user_id, $voyage_id);
        $stmt_favoris->execute();
        $result_favoris = $stmt_favoris->get_result();

        if ($result_favoris->num_rows > 0) {
            $is_in_favorites = true;
        } else {
            $is_in_favorites = false;
        }
    } else {
        $is_in_favorites = false; // Si l'utilisateur n'est pas connecté, le voyage ne peut pas être dans les favoris
    }
} else {
    echo "<p>Aucun voyage sélectionné.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du voyage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            font-size: 1.8rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .details-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .details-container img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .promotion-info {
            background-color: #ffebcd;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .btn-reservation:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="logo">Gestion Voyages</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="voyages.php">Voyages</a></li>
                    <li><a href="promotions.php">Promotions</a></li>
                    <li><a href="reservations_user.php">Réservation</a></li>
                    <li><a href="favoris.php">Favoris</a></li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo "<li><a href='logout.php' >Déconnexion</a></li>";
                    } else {
                        echo "<li><a href='authentification.php'>Connexion</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="details-container">
        <h1><?= $voyage['titre']; ?></h1>
        <p><strong>Catégorie : </strong><?= $voyage['categorie']; ?></p>
        <img src="images/<?= $voyage['image']; ?>" alt="<?= $voyage['titre']; ?>">
        <p><?= nl2br($voyage['description']); ?></p>
        <p><strong>Prix : </strong><?= $voyage['prix']; ?> DT</p>
        <p><strong>Date de départ : </strong><?=$voyage['date_depart']; ?></p>
        <p><strong>Durée : </strong><?= $voyage['duree']; ?> jours</p>
        <p><strong>Places disponibles : </strong><?= $voyage['places_disponibles']; ?></p>

        <?php if ($is_on_promotion): ?>
            <div class="promotion-info">
                <h3>Promotion en cours !</h3>
                <p><strong>Réduction : </strong><?= $promotion['pourcentage_reduction']; ?>%</p>
                <p><strong>Prix après réduction : </strong><?= number_format($prix_reduit, 2); ?> DT</p>
                <p><strong>Promotion valable jusqu'au :</strong> <?= date("d-m-Y", strtotime($promotion['date_fin'])); ?>
                </p>
            </div>
        <?php endif; ?>

        <a href="reservation.php?voyage_id=<?= $voyage['id']; ?>" class="btn btn-success mt-3 btn-reservation ">Réserver
            ce voyage</a>

        <?php if ($is_in_favorites): ?>
            <a href="supprimer_favoris.php?voyage_id=<?= $voyage['id']; ?>" class="btn btn-danger mt-3">Supprimer du
                favoris</a>
        <?php else: ?>
            <a href="ajouter_aux_favoris.php?voyage_id=<?= $voyage['id']; ?>" class="btn btn-warning mt-3">Ajouter aux
                favoris</a>
        <?php endif; ?>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'voyages.php'; ?>"
            class="btn btn-secondary mt-3">Retour</a>
    </div>
</body>

</html>