<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voyage_id = $_POST['voyage_id'];
    $pourcentage_reduction = $_POST['pourcentage_reduction'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Vérifier si le voyage a déjà une promotion active
    $current_date = date('Y-m-d');
    $stmt_check_promo = $conn->prepare("
        SELECT * FROM promotions 
        WHERE voyage_id = ? 
        AND ((date_debut <= ? AND date_fin >= ?) OR (date_debut >= ? AND date_debut <= ?))
    ");
    $stmt_check_promo->bind_param("issss", $voyage_id, $current_date, $current_date, $date_debut, $date_fin);
    $stmt_check_promo->execute();
    $result_check_promo = $stmt_check_promo->get_result();

    // Si une promotion existe déjà pour ce voyage
    if ($result_check_promo->num_rows > 0) {
        $error_message = "Ce voyage a déjà une promotion active dans la période sélectionnée.";
    } else {
        // Préparation de la requête pour éviter l'injection SQL
        $stmt = $conn->prepare("INSERT INTO promotions (voyage_id, pourcentage_reduction, date_debut, date_fin) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $voyage_id, $pourcentage_reduction, $date_debut, $date_fin);

        // Exécution de la requête et gestion des erreurs
        if ($stmt->execute()) {
            // Redirection sécurisée
            $redirect_url = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : 'admin.php?section=promotions';
            header("Location: $redirect_url");
            exit();
        } else {
            die("Erreur : " . $stmt->error);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter une Promotion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2>Ajouter une Promotion</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="voyage_id" class="form-label">Voyage</label>
            <select class="form-select" name="voyage_id" required>
                <option value="">Sélectionnez un voyage</option>
                <?php
                $voyages = $conn->query("SELECT id, titre FROM voyages");
                while ($voyage = $voyages->fetch_assoc()):
                    ?>
                    <option value="<?= $voyage['id'] ?>"><?= $voyage['titre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="pourcentage_reduction" class="form-label">Pourcentage Réduction (%)</label>
            <input type="number" class="form-control" name="pourcentage_reduction" required>
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date Début</label>
            <input type="date" class="form-control" name="date_debut" required>
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date Fin</label>
            <input type="date" class="form-control" name="date_fin" required>
        </div>
        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="admin.php?section=promotions" class="btn btn-secondary">Annuler</a>
    </form>
</body>

</html>