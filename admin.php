<?php

include 'db_connect.php';


session_start();

// Déterminer la section à afficher (par défaut : clients)
$section = isset($_GET['section']) ? $_GET['section'] : 'clients';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <style>

        /* Bouton Profil */
        .profil-button {
            background-color: #007bff;
            border-radius: 50%;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .profil-button:hover {
            background-color: #0056b3;
        }

        .profil-button svg {
            fill: white;
        }

        /* Bouton Déconnexion */
        .logout-button {
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #c82333;
        }

        .logout-button:focus {
            outline: none;
        }
    </style>

    </style>
</head>

<body class="bg-light">
    
    <header class="bg-primary text-white py-3 text-center ">
        
        <a href="profile.php" class="profil-button position-absolute top-0 start-0 ms-3 mt-3" title="Profil">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>
        </a>

       
        <a href="logout.php" class="logout-button position-absolute top-0 end-0 me-3 mt-3">Déconnexion</a>

        <h1>Tableau de Bord Administrateur</h1>

    </header>

    
    <nav class="nav nav-pills justify-content-center bg-secondary-subtle py-2">
        <a href="?section=clients" class="nav-link <?= $section == 'clients' ? 'active' : '' ?>">Gérer les Clients</a>
        <a href="?section=voyages" class="nav-link <?= $section == 'voyages' ? 'active' : '' ?>">Gérer les Voyages</a>
        <a href="?section=promotions" class="nav-link <?= $section == 'promotions' ? 'active' : '' ?>">Gérer les
            Promotions</a>
        <a href="?section=reservations" class="nav-link <?= $section == 'reservations' ? 'active' : '' ?>">Gérer les
            Réservations</a>
        <a href="?section=avis" class="nav-link <?= $section == 'avis' ? 'active' : '' ?>">Gérer les avis</a>
    </nav>

    
    <main class=" m-4 bg-secondary-subtle p-4">
        <?php if ($section == 'clients'):
            include 'gerer_client.php'; ?>
            

        <?php elseif ($section == 'voyages'): 
            include 'gerer_voyage.php';?>


        <?php elseif ($section == 'promotions'): 
            include 'gerer_promotion.php'; ?>


        <?php elseif ($section == 'reservations'): 
            include 'gerer_reservation.php'; ?>


        <?php elseif ($section == 'avis'): 
            include 'gerer_avis.php'; ?>
        <?php endif; ?>
    </main>

</body>

</html>