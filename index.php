<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion Voyages</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            background: url('images/hero-bg.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 150px 20px;
        }

        .hero h2 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            font-size: 1.2rem;
            padding: 15px 30px;
        }

        section {
            padding: 60px 0;
        }

        .about-us,
        .testimonials,
        .why-us {
            text-align: center;
        }

        .voyages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .voyage-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .voyage-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .testimonial {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .why-us .icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        footer a {
            color: #ffc107;
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
    </style>
</head>

<body>
    <!-- Header -->
    <header class="p-3 text-bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">
                    <h1 class="m-0">Gestion Voyages</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a href="#about-us" class="nav-link">À Propos de Nous</a></li>
                        <li class="nav-item"><a href="#why-us" class="nav-link">Pourquoi Nous ?</a></li>
                        <li class="nav-item"><a href="#voyages" class="nav-link">Voyages</a></li>
                        <li class="nav-item"><a href="#user-promotions" class="nav-link">Promotions</a></li>
                        <li class="nav-item"><a href="#testimonials" class="nav-link">Témoignages</a></li>

                    </ul>

                    <div class="d-flex">
                        <?php if (isset($_SESSION['id'])): ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Mon Espace
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="profile.php">Profil</a></li>
                                    <li><a class="dropdown-item" href="favoris.php">Favoris</a></li>
                                    <li><a class="dropdown-item" href="reservations_user.php">Réservations</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="logout.php">Déconnexion</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="authentification.php" class="btn btn-outline-light me-2">Connexion</a>
                            <a href="inscription.php" class="btn btn-warning">Créer un compte</a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </header>



    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <?php if (isset($_SESSION['id'])): ?>
                <h1 class="text-success">Bienvenue, <?php echo $_SESSION['nom']; ?>!</h1>
            <?php endif; ?>
            <h2>Explorez le monde avec nous</h2>
            <p>Des expériences inoubliables, des destinations de rêve.</p>
            <a href="voyages.php" class="btn btn-primary btn-lg">Voir les voyages</a>
        </div>
    </section>

    <!-- À Propos de Nous Section -->
    <section id="about-us" class="about-us">
        <div class="container">
            <h2>À Propos de Nous</h2>
            <div class="icon"><i class="fas fa-users"></i></div>
            <p>
                Chez Gestion Voyages, nous sommes passionnés par le voyage. Notre objectif est de vous offrir des
                expériences uniques dans des destinations magnifiques.
            </p>
        </div>
    </section>

    <!-- Pourquoi Nous Section -->
    <section id="why-us" class="why-us">
        <div class="container">
            <h2>Pourquoi Nous ?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="icon"><i class="fas fa-plane"></i></div>
                    <h3>Des Voyages Uniques</h3>
                    <p>Des destinations soigneusement sélectionnées pour vous offrir des souvenirs inoubliables.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon"><i class="fas fa-handshake"></i></div>
                    <h3>Service de Qualité</h3>
                    <p>Une équipe dédiée à répondre à vos besoins et à garantir votre satisfaction.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon"><i class="fas fa-globe"></i></div>
                    <h3>Prix Compétitifs</h3>
                    <p>Des tarifs avantageux sans compromis sur la qualité de nos services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Voyages -->
    <section id="voyages" class="popular-voyages">
        <div class="container">
            <h2 class="text-center mb-4">Nos Voyages Populaires</h2>
            <div class="voyages-grid">
                <?php
                include('db_connect.php');

                $sql = "SELECT id, titre, description, prix, image FROM voyages LIMIT 4";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="voyage-card">';
                        echo '<img src="images/' . $row['image'] . '" alt="' . $row['titre'] . '">';
                        echo '<h3>' . $row['titre'] . '</h3>';
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<p><strong>' . $row['prix'] . ' TND</strong></p>';
                        echo '<a href="details_voyage.php?id=' . $row['id'] . '" class="btn btn-primary">En savoir plus</a>';
                        echo '</div>';

                    }

                } else {
                    echo '<p class="text-center">Aucun voyage disponible pour le moment.</p>';
                }
                ?>

            </div>
            <div class="text-center mt-4">
                <a href="voyages.php" class="btn btn-secondary">Voir tout</a>
            </div>
        </div>
    </section>


    <section id="user-promotions" class="user-promotions">
        <div class="container">
            <h2 class="text-center mb-4">Nos Promotions</h2>
            <div class="voyages-grid">
                <?php


                $sql = "SELECT promotions.id AS promo_id, voyages.id AS voyage_id,voyages.titre, voyages.description,voyages.prix, voyages.image,
        promotions.pourcentage_reduction,promotions.date_debut,promotions.date_fin
    FROM promotions
    INNER JOIN voyages 
    ON promotions.voyage_id = voyages.id
    WHERE CURRENT_DATE < promotions.date_fin
    LIMIT 2";


                $result = $conn->query($sql);

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
                    echo '<p class="text-center">Aucune promotion en cours pour le moment.</p>';
                }

                ?>
            </div>
            <div class="text-center mt-4">
                <a href="promotions.php" class="btn btn-secondary">Voir tout</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <h2>Témoignages</h2>
            <p>Découvrez ce que disent nos clients.</p>

            <?php

            // Afficher les témoignages existants
            $sql = "SELECT users.nom, testimonials.message 
    FROM testimonials 
    INNER JOIN users 
    ON testimonials.id_user = users.id 
    ORDER BY testimonials.created_at DESC 
    LIMIT 3
";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="testimonial">';
                    echo '<p>"' . $row['message'] . '"</p>';
                    echo '<strong>- ' . $row['nom'] . '</strong>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun témoignage disponible pour le moment.</p>';
            }
            ?>
            <div class="text-center mt-4">
                <a href="avis.php" class="btn btn-secondary">Voir tout</a>
            </div>

            <!-- Formulaire pour ajouter un témoignage (si l'utilisateur est connecté) -->
            <?php if (isset($_SESSION['id'])): ?>
                <div class="add-testimonial">
                    <h3>Ajoutez votre avis</h3>
                    <form action="ajouter_avis.php" method="POST">
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4" placeholder="Votre message..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            <?php endif;
            $conn->close();
            ?>

        </div>
    </section>







    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Gestion Voyages </a>
        </p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>