<h2>Gérer les Voyages</h2>
<a href="ajout_voyage.php" class="btn btn-success mb-3">Ajouter un Voyage</a>

<!-- Formulaire de filtre -->
<form method="POST" action="" class="mb-3">
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="filtre_titre" class="form-control" placeholder="Filtrer par titre"
                value="<?= isset($_POST['filtre_titre']) ? $_POST['filtre_titre'] : '' ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" name="filtrer" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </div>
</form>

<!-- Table des Voyages -->
<table class="table table-striped table-hover">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialiser la requête
        $query = "SELECT * FROM voyages";

        // Appliquer le filtre si un titre est saisi
        if (isset($_POST['filtre_titre']) && !empty($_POST['filtre_titre'])) {
            $filtre_titre = $_POST['filtre_titre'];
            $query .= " WHERE titre LIKE '%$filtre_titre%'";
        }

        // Exécuter la requête
        $result = $conn->query($query);

        // Afficher les voyages
        while ($voyage = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $voyage['id'] ?></td>
                <td><?= $voyage['titre'] ?></td>
                <td><?= $voyage['description'] ?></td>
                <td><?= $voyage['prix'] ?> €</td>
                <td>
                    <a href="modifier_voyage.php?id=<?= $voyage['id'] ?>"
                        class="btn btn-sm btn-outline-info mb-2">Modifier</a>
                    <a href="supprimer_voyage.php?id=<?= $voyage['id'] ?>"
                        class="btn btn-sm btn-outline-danger">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>