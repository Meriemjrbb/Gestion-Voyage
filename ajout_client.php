<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash du mot de passe
    $role = $_POST['role'];

    // Éviter l'injection SQL en utilisant des requêtes préparées
    $stmt = $conn->prepare("INSERT INTO users (nom, email, telephone, adresse, mot_de_passe, role, date_creation) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssss", $nom, $email, $telephone, $adresse, $mot_de_passe, $role);

    // Exécution de la requête et gestion des erreurs
    if ($stmt->execute()) {
        // Redirection sécurisée
        $redirect_url = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : 'admin.php';
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
    <title>Ajouter un Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Ajouter un Client</h1>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de Passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="utilisateur">Utilisateur</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">

            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="admin.php?section=clients" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>

</html>