<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $voyage_id = $_POST['voyage_id'];
    $nb_places_reserv = $_POST['nb_places_reserv'];
    $statut = $_POST['statut'];

    // Préparation de la requête pour éviter l'injection SQL
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, voyage_id, nb_places_reserv, statut) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $voyage_id, $nb_places_reserv, $statut);

    // Exécution de la requête et gestion des erreurs
    if ($stmt->execute()) {
        // Redirection sécurisée
        $redirect_url = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : 'admin.php?section=reservations';
        header("Location: $redirect_url");
        exit();
    } else {
        die("Erreur : " . $stmt->error);
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Réservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h2>Ajouter une Réservation</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">Utilisateur</label>
            <select class="form-select" name="user_id" required>
                <option value="">Sélectionnez un utilisateur</option>
                <?php
                $users = $conn->query("SELECT id, nom FROM users");
                while ($user = $users->fetch_assoc()): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['nom'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="voyage_id" class="form-label">Voyage</label>
            <select class="form-select" name="voyage_id" required>
                <option value="">Sélectionnez un voyage</option>
                <?php
                $voyages = $conn->query("SELECT id, titre FROM voyages");
                while ($voyage = $voyages->fetch_assoc()): ?>
                    <option value="<?= $voyage['id'] ?>"><?= $voyage['titre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nb_places_reserv" class="form-label">Nombre de places</label>
            <input type="number" class="form-control" name="nb_places_reserv" min="1" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" name="statut" required>
                <option value="en attente">En attente</option>
                <option value="confirmé">Acceptée</option>
                <option value="annulé">Refusée</option>
            </select>
        </div>
        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="admin.php?section=reservations" class="btn btn-secondary">Annuler</a>
    </form>

</body>

</html>