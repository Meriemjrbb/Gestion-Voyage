<?php
session_start();
include('db_connect.php');


if (!isset($_SESSION['id'])) {
    header('Location: authentification.php');
    exit();
}

$user_id = $_SESSION['id'];

// Filtrer les réservations selon leur statut
$statut_filter = '';

// Vérifier si un filtre de statut a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['statut'])) {
    $statut_filter = $_POST['statut'];
}

$sql = "SELECT r.id AS reservation_id, r.nb_places_reserv, r.statut, r.date_reservation, 
               v.titre, v.description, v.prix, v.date_depart, v.duree, v.image
        FROM reservations r
        JOIN voyages v ON r.voyage_id = v.id
        WHERE r.user_id = ?";

// Ajouter la condition de statut si un filtre est appliqué
if ($statut_filter != '') {
    $sql .= " AND r.statut = ?";
}

$stmt = $conn->prepare($sql);
if ($statut_filter != '') {
    $stmt->bind_param("is", $user_id, $statut_filter);
} else {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .reservations {
            padding: 60px 20px;
            background-color: #f9f9f9;
        }

        .reservations h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }

        .reservation-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .reservation-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .reservation-card h3 {
            font-size: 1.5rem;
            margin: 15px 0;
        }

        .reservation-card p {
            margin: 10px 15px;
            color: #555;
        }

        .reservation-card strong {
            font-size: 1.2rem;
            color: #007bff;
        }

        .reservation-card .btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            margin: 15px 0;
            border-radius: 5px;
            text-decoration: none;
        }

        .reservation-card .btn:hover {
            background-color: #a71d2a;
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

    <section class="reservations">
        <div class="container">
            <h2>Mes Réservations</h2>

            <!-- Formulaire de filtrage -->
            <form method="POST" action="reservations_user.php">
                <div class="form-group mb-3">
                    <label for="statut">Filtrer par statut :</label>
                    <select name="statut" id="statut" class="form-control">
                        <option value="">Tous</option>
                        <option value="confirmé" <?php echo ($statut_filter == 'confirmé') ? 'selected' : ''; ?>>Confirmé
                        </option>
                        <option value="en attente" <?php echo ($statut_filter == 'en attente') ? 'selected' : ''; ?>>En
                            attente</option>
                        <option value="annulé" <?php echo ($statut_filter == 'annulé') ? 'selected' : ''; ?>>Annulé
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>

            <div class="reservations-grid mt-4">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="reservation-card">';
                        echo '<img src="images/' . $row['image'] . '" alt="' . $row['titre'] . '">';
                        echo '<h3>' . $row['titre'] . '</h3>';
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<p>Date de départ : <strong>' . $row['date_depart'] . '</strong></p>';
                        echo '<p>Nombre de places réservées : <strong>' . $row['nb_places_reserv'] . '</strong></p>';
                        echo '<p>Statut : <strong>' .
                            ($row['statut'] == 'annulé' ? '<span style="color: red;">Annulé</span>' :
                                ($row['statut'] == 'confirmé' ? '<span style="color: blue;">Confirmé</span>' :
                                    '<span style="color: orange;">En attente</span>')) .
                            '</strong></p>';
                        echo '<p>Prix total : <strong>' . ($row['nb_places_reserv'] * $row['prix']) . ' TND</strong></p>';
                        echo '<a href="supprimer_reservation.php?id=' . $row['reservation_id'] . ' class="btn btn-danger">Supprimer</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Vous n\'avez aucune réservation pour le moment.</p>';
                }
                ?>
            </div>
        </div>
    </section>
</body>

</html>