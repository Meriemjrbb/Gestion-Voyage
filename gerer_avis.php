<h2>Gérer les Avis</h2>
<table class="table table-striped table-hover">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Message</th>
            <th>Date de Création</th>
            <th>Actions</th>
        </tr>
    </thead>
    <?php
    // Requête pour récupérer les avis avec le nom de l'utilisateur
    $result = $conn->query("
            SELECT testimonials.id, testimonials.message, testimonials.created_at, users.nom AS utilisateur
            FROM testimonials
            JOIN users ON testimonials.id_user = users.id
        ");
    while ($avis = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $avis['id'] ?></td>
            <td><?php echo $avis['utilisateur'] ?></td>
            <td><?php echo $avis['message'] ?></td>
            <td><?php echo $avis['created_at'] ?></td>
            <td>
                <!-- Bouton pour supprimer un avis -->
                <a href="supprimer_avis.php?id=<?= $avis['id'] ?>" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>