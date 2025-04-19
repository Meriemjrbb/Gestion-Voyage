<h2>Gérer les Réservations</h2>
<a href="ajout_reservation.php" class="btn btn-success mb-3 mt-2">Ajouter une Réservation</a>

<!-- Formulaire de filtre -->
<form method="POST" action="" class="mb-3">
    <div class="row mb-3">
        <div class="col-md-3">
            <select name="filtre_voyage" class="form-control">
                <option value="">Filtrer par Voyage</option>
                <?php
                // Récupérer tous les voyages
                $voyagesResult = $conn->query("SELECT id, titre FROM voyages");
                while ($voyage = $voyagesResult->fetch_assoc()): ?>
                    <option value="<?= $voyage['id'] ?>" <?= isset($_POST['filtre_voyage']) && $_POST['filtre_voyage'] == $voyage['id'] ? 'selected' : '' ?>>
                        <?= $voyage['titre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="filtre_statut" class="form-control">
                <option value="">Filtrer par Statut</option>
                <option value="confirmé" <?= isset($_POST['filtre_statut']) && $_POST['filtre_statut'] == 'confirmé' ? 'selected' : '' ?>>Confirmé</option>
                <option value="en attente" <?= isset($_POST['filtre_statut']) && $_POST['filtre_statut'] == 'en attente' ? 'selected' : '' ?>>En Attente</option>
                <option value="annulé" <?= isset($_POST['filtre_statut']) && $_POST['filtre_statut'] == 'annulé' ? 'selected' : '' ?>>Annulé</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" name="filtrer" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </div>
</form>

<!-- Table des Réservations -->
<table class="table table-striped table-hover">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Voyage</th>
            <th>nb de places</th>
            <th>Statut</th>
            <th>Date Réservation</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialiser la requête
        $query = "
            SELECT reservations.id, users.nom AS utilisateur, voyages.titre AS voyage, reservations.nb_places_reserv,
                   reservations.statut, reservations.date_reservation
            FROM reservations
            JOIN users ON reservations.user_id = users.id
            JOIN voyages ON reservations.voyage_id = voyages.id
        ";

        // Appliquer le filtre par voyage si sélectionné
        if (isset($_POST['filtre_voyage']) && !empty($_POST['filtre_voyage'])) {
            $filtre_voyage = $_POST['filtre_voyage'];
            $query .= " WHERE voyages.id = $filtre_voyage";
        }

        // Appliquer le filtre par statut si sélectionné
        if (isset($_POST['filtre_statut']) && !empty($_POST['filtre_statut'])) {
            $filtre_statut = $_POST['filtre_statut'];
            $query .= isset($_POST['filtre_voyage']) ? " AND reservations.statut = '$filtre_statut'" : " WHERE reservations.statut = '$filtre_statut'";
        }

        // Exécuter la requête
        $result = $conn->query($query);

        // Afficher les réservations
        while ($reservation = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $reservation['id'] ?></td>
                <td><?= $reservation['utilisateur'] ?></td>
                <td><?= $reservation['voyage'] ?></td>
                <td><?= $reservation['nb_places_reserv'] ?></td>
                <td><?= $reservation['statut'] ?></td>
                <td><?= $reservation['date_reservation'] ?></td>
                <td>
                    <a href="modifier_reservation.php?id=<?= $reservation['id'] ?>"
                        class="btn btn-sm btn-outline-info mb-2">Modifier</a>
                    <a href="supprimer_reservation.php?id=<?= $reservation['id'] ?>" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>