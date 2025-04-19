<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $role = $_POST['role'];
    $mot_de_passe = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT) : null;

    // Mise à jour d'un utilisateur existant
    $client_id = intval($_GET['id']);

    if ($mot_de_passe) {
        $stmt = $conn->prepare("UPDATE users SET nom = ?, email = ?, telephone = ?, adresse = ?, mot_de_passe = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $nom, $email, $telephone, $adresse, $mot_de_passe, $role, $client_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET nom = ?, email = ?, telephone = ?, adresse = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nom, $email, $telephone, $adresse, $role, $client_id);
    }

    
    if ($stmt->execute()) {
        $redirect_url = isset($_POST['redirect_url']) ?$_POST['redirect_url'] : 'admin.php';
        header("Location: $redirect_url");
        exit();
    } else {
        die("Erreur : " . $stmt->error);
    }
}

// le rempliisaage des champs
$client_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
} else {
    die("Client non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Modifier un Client</h1>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom"
                    value="<?=$client['nom']?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= $client['email']?>" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone"
                    value="<?= $client['telephone'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse"
                    value="<?= $client['adresse'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Nouveau Mot de Passe (laisser vide pour conserver
                    l'ancien)</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="utilisateur" <?= $client['role'] == 'utilisateur' ? 'selected' : '' ?>>Utilisateur
                    </option>
                    <option value="admin" <?= $client['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <input type="hidden" name="redirect_url" value="<?= $_SERVER['HTTP_REFERER']; ?>">
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="admin.php?section=clients" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>

</html>