<?php
include 'db_connect.php';

$id = $_GET['id'];
$promotion = $conn->prepare("SELECT * FROM promotions WHERE id = ?");
$promotion->bind_param("i", $id);
$promotion->execute();
$result = $promotion->get_result();
$promotion_data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voyage_id = $_POST['voyage_id'];
    $pourcentage_reduction = $_POST['pourcentage_reduction'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Préparation de la requête 
    $stmt = $conn->prepare("UPDATE promotions SET voyage_id = ?, pourcentage_reduction = ?, date_debut = ?, date_fin = ? WHERE id = ?");
    $stmt->bind_param("iissi", $voyage_id, $pourcentage_reduction, $date_debut, $date_fin, $id);

   
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
<html>

<head>
    <title>Modifier une Promotion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2>Modifier une Promotion</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="voyage_id" class="form-label">Voyage</label>
            <select class="form-select" name="voyage_id" required>
                <?php
                $voyages = $conn->query("SELECT id, titre FROM voyages");
                while ($voyage = $voyages->fetch_assoc()):
                    ?>
                    <option value="<?= $voyage['id'] ?>" <?= $voyage['id'] == $promotion_data['voyage_id'] ? 'selected' : '' ?>>
                        <?= $voyage['titre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="pourcentage_reduction" class="form-label">Pourcentage Réduction (%)</label>
            <input type="number" class="form-control" name="pourcentage_reduction"
                value="<?= $promotion_data['pourcentage_reduction'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date Début</label>
            <input type="date" class="form-control" name="date_debut" value="<?= $promotion_data['date_debut'] ?>"
                required>
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date Fin</label>
            <input type="date" class="form-control" name="date_fin" value="<?= $promotion_data['date_fin'] ?>" required>
        </div>
        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">
        <button type="submit" class="btn btn-info">Modifier</button>
        <a href="admin.php?section=promotions" class="btn btn-secondary">Annuler</a>
    </form>
</body>

</html>