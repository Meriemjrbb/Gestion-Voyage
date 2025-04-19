<h2>Gérer les Clients</h2>

<!-- Formulaire de tri -->
<a href="ajout_client.php" class="btn btn-success mb-3 mt-2">Ajouter un Client</a>
<form method="POST" action="" class="mb-3">
    <div class="row mb-3">
        <div class="col-md-3">
            <select name="tri" class="form-control">
                <option value="id" <?= isset($_POST['tri']) && $_POST['tri'] == 'id' ? 'selected' : '' ?>>ID</option>
                <option value="nom" <?= isset($_POST['tri']) && $_POST['tri'] == 'nom' ? 'selected' : '' ?>>Nom</option>
                <option value="date_creation" <?= isset($_POST['tri']) && $_POST['tri'] == 'date_creation' ? 'selected' : '' ?>>Date de création</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" name="trier" class="btn btn-primary w-100">Trier</button>
        </div>
    </div>
</form>

<!-- Table  -->
<table class="table table-striped table-hover">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Date de Création du Compte</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialiser la requête
        $query = "SELECT * FROM users WHERE role = 'utilisateur'";

       
        if (isset($_POST['tri'])) {
            $tri = $_POST['tri'];
            $query .= " ORDER BY $tri";
        }

        
        $result = $conn->query($query);

        // Afficher les clients
        while ($client = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $client['id'] ?></td>
                <td><?= $client['nom'] ?></td>
                <td><?= $client['email'] ?></td>
                <td><?= $client['telephone'] ?></td>
                <td><?= $client['adresse'] ?></td>
                <td><?= $client['date_creation'] ?></td>
                <td>
                    <a href="modifier_client.php?id=<?= $client['id'] ?>"
                        class="btn btn-sm btn-outline-info mb-2">Modifier</a>
                    <a href="supprimer_client.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>