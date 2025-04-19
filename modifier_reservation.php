<?php
include 'db_connect.php';

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête pour récupérer les informations de la réservation
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();

    // Si la réservation n'existe pas, afficher un message d'erreur
    if (!$reservation) {
        die("Réservation non trouvée.");
    }
}

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $voyage_id = $_POST['voyage_id'];
    $nb_places_reserv = $_POST['nb_places_reserv'];
    $statut = $_POST['statut'];

    // Préparer la requête pour mettre à jour la réservation
    $stmt = $conn->prepare("UPDATE reservations SET user_id = ?, voyage_id = ?, nb_places_reserv = ?, statut = ? WHERE id = ?");
    $stmt->bind_param("iiisi", $user_id, $voyage_id, $nb_places_reserv, $statut, $id);

    // Exécuter la requête et vérifier le succès
    if ($stmt->execute()) {
        // Redirection sécurisée
        $redirect_url = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : 'admin.php?section=promotions';
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
    <title>Modifier une Réservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2>Modifier une Réservation</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">Utilisateur</label>
            <select class="form-select" name="user_id" required>
                <?php
                $users = $conn->query("SELECT id, nom FROM users");
                while ($user = $users->fetch_assoc()): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $reservation['user_id'] ? 'selected' : '' ?>>
                        <?= $user['nom'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="voyage_id" class="form-label">Voyage</label>
            <select class="form-select" name="voyage_id" required>
                <?php
                $voyages = $conn->query("SELECT id, titre FROM voyages");
                while ($voyage = $voyages->fetch_assoc()): ?>
                    <option value="<?= $voyage['id'] ?>" <?= $voyage['id'] == $reservation['voyage_id'] ? 'selected' : '' ?>>
                        <?= $voyage['titre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nb_places_reserv" class="form-label">Nombre de places</label>
            <input type="number" class="form-control" name="nb_places_reserv" min="1" required
                value="<?= $reservation['nb_places_reserv'] ?>">
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" name="statut" required>
                <option value="en attente" <?= $reservation['statut'] == 'en attente' ? 'selected' : '' ?>>en attente
                </option>
                <option value="confirmé" <?= $reservation['statut'] == 'confirmé' ? 'selected' : '' ?>>confirmé</option>
                <option value="annulé" <?= $reservation['statut'] == 'annulé' ? 'selected' : '' ?>>annulé</option>
            </select>
        </div>
        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">

        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="admin.php?section=reservations" class="btn btn-secondary">Annuler</a>
    </form>
</body>

</html>