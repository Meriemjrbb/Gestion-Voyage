<?php
session_start();
include('db_connect.php'); 

// Vérifier si un tri a été soumis via POST
$tri = isset($_POST['tri']) && $_POST['tri'] == 'asc' ? 'ASC' : 'DESC';

// Requête pour récupérer les promotions  des voyages triées par pourcentage de réduction
$sql = "
    SELECT 
        promotions.id AS promo_id,
        voyages.id AS voyage_id,
        voyages.titre,
        voyages.description,
        voyages.prix,
        voyages.image,
        promotions.pourcentage_reduction,
        promotions.date_debut,
        promotions.date_fin
    FROM 
        promotions
    INNER JOIN 
        voyages 
    ON 
        promotions.voyage_id = voyages.id
    WHERE 
        CURRENT_DATE < promotions.date_fin
    ORDER BY 
        promotions.pourcentage_reduction $tri
"; // Tri par pourcentage de réduction

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions - Gestion Voyages</title>
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

        .dates {
            color: gray;
            font-weight: bold;
        }

        .promotions {
            padding: 60px 20px;
            background-color: #f9f9f9;
        }

        .promotions h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }

        .promotions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .promotion-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .promotion-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .promotion-card h3 {
            font-size: 1.5rem;
            margin: 15px 0;
        }

        .promotion-card p {
            margin: 10px 15px;
            color: #555;
        }

        .promotion-card .prix-original {
            text-decoration: line-through;
            color: red;
            font-weight: bold;
        }

        .promotion-card .prix-reduit {
            font-size: 1.2rem;
            color: green;
            font-weight: bold;
        }

        .promotion-card .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin: 15px 0;
            border-radius: 5px;
            text-decoration: none;
        }

        .promotion-card .btn:hover {
            background-color: #0056b3;
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

    <!-- Formulaire pour trier par pourcentage de réduction -->
    <section class="promotions">
        <div class="container">
            <h2>Nos Promotions</h2>

            <form method="POST" action="promotions.php" class="mb-4">
                <label for="tri">Trier par réduction : </label>
                <select name="tri" id="tri">
                    <option value="desc" <?php echo $tri == 'DESC' ? 'selected' : ''; ?>>Réduction décroissante</option>
                    <option value="asc" <?php echo $tri == 'ASC' ? 'selected' : ''; ?>>Réduction croissante</option>
                </select>
                <button type="submit" class="btn btn-primary">Trier</button>
            </form>

            <div class="promotions-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Calculer le prix après réduction
                        $prix_reduit = $row['prix'] - ($row['prix'] * $row['pourcentage_reduction'] / 100);

                        echo '<div class="promotion-card">';
                        echo '<img src="images/' . $row['image'] . '" alt="' . $row['titre'] . '">';
                        echo '<h3>' . $row['titre'] . '</h3>';
                        echo '<p style="color: #ffcc10;"><strong>Réduction : ' . $row['pourcentage_reduction'] . '%</strong></p>';
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<p class="prix-original">' . $row['prix'] . ' TND</p>';
                        echo '<p class="prix-reduit">' . number_format($prix_reduit, 2) . ' TND</p>';
                        echo '<p class="dates">Du ' . date("d-m-Y", strtotime($row['date_debut'])) . ' au ' . date("d-m-Y", strtotime($row['date_fin'])) . '</p>';
                        echo '<a href="details_voyage.php?id=' . $row['voyage_id'] . '" class="btn">Voir les détails</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Aucune promotion disponible pour le moment.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Gestion Voyages </a>
        </p>
    </footer>
</body>

</html>