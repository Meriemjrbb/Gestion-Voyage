<?php
session_start();
include('db_connect.php');

//le tri par prix 
$sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'asc';

// Récupérer les voyages depuis la base de données avec le tri par prix
$sql = "SELECT id, titre, description, prix, image FROM voyages ORDER BY prix $sort_by";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyages - Gestion Voyages</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

        .voyages {
            padding: 60px 20px;
            background-color: #f9f9f9;
        }

        .voyages h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }

        .voyages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .voyage-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .voyage-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .voyage-card h3 {
            font-size: 1.5rem;
            margin: 15px 0;
        }

        .voyage-card p {
            margin: 10px 15px;
            color: #555;
        }

        .voyage-card strong {
            font-size: 1.2rem;
            color: #007bff;
        }

        .voyage-card .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin: 15px 0;
            border-radius: 5px;
            text-decoration: none;
        }

        .voyage-card .btn:hover {
            background-color: #0056b3;
        }

        .sort-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .sort-container select {
            padding: 8px 12px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
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


    <section class="voyages">
        <div class="container">
            <h2>Nos Voyages</h2>

            <!-- Formulaire de tri par prix -->
            <div class="sort-container">
                <form method="POST">
                    <label for="sort_by">Trier par prix :</label>
                    <select name="sort_by" id="sort_by">
                        <option value="asc" <?= $sort_by == 'asc' ? 'selected' : '' ?>>Prix croissant</option>
                        <option value="desc" <?= $sort_by == 'desc' ? 'selected' : '' ?>>Prix décroissant</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Appliquer</button>
                </form>
            </div>

            <div class="voyages-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="voyage-card">';
                        echo '<img src="images/' . $row['image'] . '" alt="' . $row['titre'] . '">';
                        echo '<h3>' . $row['titre'] . '</h3>';
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<p><strong>' . $row['prix'] . ' TND</strong></p>';
                        echo '<a href="details_voyage.php?id=' . $row['id'] . '" class="btn">Voir les détails</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Aucun voyage disponible pour le moment.</p>';
                }
                ?>
            </div>
        </div>
    </section>


    <footer>
        <p>&copy; 2024 Gestion Voyages |</a>
        </p>
    </footer>
</body>

</html>