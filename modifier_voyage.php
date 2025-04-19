<?php
include('db_connect.php');

$id = $_GET['id'];
$voyage = $conn->query("SELECT * FROM voyages WHERE id = $id")->fetch_assoc();
$categories = $conn->query("SELECT id, nom FROM categories");

if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id'];

    $stmt = $conn->prepare("UPDATE voyages SET titre = ?, description = ?, prix = ?, categorie_id = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $titre, $description, $prix, $categorie_id, $id);
    if ($stmt->execute()) {
        // Redirection sécurisée
        $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'admin.php?section=promotions';
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
    <title>Modifier un Voyage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Modifier un Voyage</h2>
        <form action="modifier_voyage.php?id=<?= $id ?>" method="POST" class="border p-4 rounded shadow">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre :</label>
                <input type="text" id="titre" name="titre" class="form-control" value="<?= $voyage['titre'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control"
                    required><?= $voyage['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix (€) :</label>
                <input type="number" id="prix" name="prix" class="form-control" value="<?= $voyage['prix'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Catégorie :</label>
                <select id="categorie_id" name="categorie_id" class="form-select" required>
                    <?php while ($categorie = $categories->fetch_assoc()): ?>
                        <option value="<?= $categorie['id'] ?>" <?= ($categorie['id'] == $voyage['categorie_id']) ? 'selected' : '' ?>>
                            <?= $categorie['nom'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" name="redirect_url" value="<?= $_SERVER['HTTP_REFERER']; ?>">
            <button type="submit" name="submit" class="btn btn-info">Modifier</button>
        </form>
    </div>
</body>

</html>