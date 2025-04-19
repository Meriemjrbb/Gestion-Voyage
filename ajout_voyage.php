<?php
include('db_connect.php');

// Récupérer toutes les catégories
$categories = $conn->query("SELECT id, nom FROM categories");

if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $date_depart = $_POST['date_depart'];
    $duree = $_POST['duree'];
    $places_disponibles = $_POST['places_disponibles'];
    $categorie_id = $_POST['categorie_id'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if (move_uploaded_file($image_tmp, './images/' . $image_name)) {
        $stmt = $conn->prepare("INSERT INTO voyages (titre, description, prix, date_depart, duree, places_disponibles, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsdssi", $titre, $description, $prix, $date_depart, $duree, $places_disponibles, $image_name, $categorie_id);
        if ($stmt->execute()) {

            $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'admin.php?section=voyages';
            header("Location: $redirect_url");
            exit();
        } else {
            die("Erreur : " . $stmt->error);
        }

    } else {
        die("Échec de l'upload de l'image.");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Voyage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Ajouter un Voyage</h2>
        <form action="ajout_voyage.php" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre :</label>
                <input type="text" id="titre" name="titre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix (€) :</label>
                <input type="number" id="prix" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date_depart" class="form-label">Date de départ :</label>
                <input type="date" id="date_depart" name="date_depart" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="duree" class="form-label">Durée (jours) :</label>
                <input type="number" id="duree" name="duree" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="places_disponibles" class="form-label">Places disponibles :</label>
                <input type="number" id="places_disponibles" name="places_disponibles" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image :</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Catégorie :</label>
                <select id="categorie_id" name="categorie_id" class="form-select" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php while ($categorie = $categories->fetch_assoc()): ?>
                        <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" name="redirect_url" value="<?= $_SERVER['HTTP_REFERER']; ?>">
            <button type="submit" name="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>
</body>

</html>