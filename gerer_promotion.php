<h2>Gérer les Promotions</h2>
<a href="ajout_promotion.php" class="btn btn-success mb-3 mt-2">Ajouter une Promotion</a>

<!-- Formulaire de filtre -->
<form method="POST" action="" class="mb-3">
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="filtre_voyage" class="form-control" placeholder="Filtrer par Voyage"
                value="<?= isset($_POST['filtre_voyage']) ? $_POST['filtre_voyage'] : '' ?>">
        </div>
        <div class="col-md-3">
            <input type="number" name="filtre_pourcentage" class="form-control" placeholder="Filtrer par % Réduction"
                value="<?= isset($_POST['filtre_pourcentage']) ? $_POST['filtre_pourcentage'] : '' ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" name="filtrer" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </div>
</form>

<!-- Options de tri -->
<form method="POST" action="" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <select name="tri_option" class="form-control">
                <option value="">Trier par</option>
                <option value="date_debut" <?= isset($_POST['tri_option']) && $_POST['tri_option'] == 'date_debut' ? 'selected' : '' ?>>Date Début</option>
                <option value="date_fin" <?= isset($_POST['tri_option']) && $_POST['tri_option'] == 'date_fin' ? 'selected' : '' ?>>Date Fin</option>
                <option value="pourcentage_reduction" <?= isset($_POST['tri_option']) && $_POST['tri_option'] == 'pourcentage_reduction' ? 'selected' : '' ?>>Pourcentage Réduction</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" name="trier" class="btn btn-primary w-100">Trier</button>
        </div>
    </div>
</form>

<!-- Table des Promotions -->
<table class="table table-striped table-hover">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Voyage</th>
            <th>Pourcentage Réduction</th>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialiser la requête
        $query = "
            SELECT promotions.id, voyages.titre AS voyage, promotions.pourcentage_reduction, 
                   promotions.date_debut, promotions.date_fin
            FROM promotions
            JOIN voyages ON promotions.voyage_id = voyages.id
        ";

        // Appliquer le filtre si un voyage ou pourcentage est saisi
        if (isset($_POST['filtre_voyage']) && !empty($_POST['filtre_voyage'])) {
            $filtre_voyage = $_POST['filtre_voyage'];
            $query .= " WHERE voyages.titre LIKE '%$filtre_voyage%'";
        }
        if (isset($_POST['filtre_pourcentage']) && !empty($_POST['filtre_pourcentage'])) {
            $filtre_pourcentage = $_POST['filtre_pourcentage'];
            $query .= isset($_POST['filtre_voyage']) ? " AND promotions.pourcentage_reduction >= $filtre_pourcentage" : " WHERE promotions.pourcentage_reduction >= $filtre_pourcentage";
        }

        // Appliquer le tri si une option de tri est sélectionnée
        if (isset($_POST['tri_option']) && !empty($_POST['tri_option'])) {
            $tri_option = $_POST['tri_option'];
            $query .= " ORDER BY $tri_option";
        }

        // Exécuter la requête
        $result = $conn->query($query);

        // Afficher les promotions
        while ($promotion = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $promotion['id'] ?></td>
                <td><?= $promotion['voyage'] ?></td>
                <td><?= $promotion['pourcentage_reduction'] ?>%</td>
                <td><?= $promotion['date_debut'] ?></td>
                <td><?= $promotion['date_fin'] ?></td>
                <td>
                    <a href="modifier_promotion.php?id=<?= $promotion['id'] ?>"
                        class="btn btn-sm btn-outline-info mb-2">Modifier</a>
                    <a href="supprimer_promotion.php?id=<?= $promotion['id'] ?>" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>