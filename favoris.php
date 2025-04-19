<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['id'])) {
    header("Location: authentification.php");
    exit();
}

$user_id = $_SESSION['id'];

// Récupérer les favoris de l'utilisateur
$sql = "
    SELECT v.id AS voyage_id, v.titre, v.description, v.prix, v.image, v.date_depart, v.duree 
    FROM favoris f 
    JOIN voyages v ON f.voyage_id = v.id 
    WHERE f.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>

<body>
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

    <main class="container mt-4">
        <h2>Liste de vos favoris</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" class="card-img-top" alt="' . $row['titre'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['titre'] . '</h5>';
                    echo '<p class="card-text">' . substr($row['description'], 0, 100) . '...</p>';
                    echo '<p class="card-text"><strong>Prix : </strong>' . $row['prix'] . ' TND</p>';
                    echo '<p class="card-text"><strong>Date de départ : </strong>' . $row['date_depart'] . '</p>';
                    echo '<p class="card-text"><strong>Durée : </strong>' . $row['duree'] . ' jours</p>';
                    echo '<a href="supprimer_favoris.php?voyage_id=' . $row['voyage_id'] . '" class="btn btn-danger">Supprimer</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<p class="alert alert-info">Vous n\'avez aucun favori pour le moment.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        <p>&copy; 2024 Votre site de voyages. </p>
    </footer>
</body>

</html>