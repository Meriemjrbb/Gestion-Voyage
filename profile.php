<?php
include 'db_connect.php';
session_start();


// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Traiter les modifications
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];


    $stmt = $conn->prepare("UPDATE users SET nom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nom, $email, $telephone, $adresse, $user_id);
    $stmt->execute();

    // Redirection sécurisée vers la page précédente
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'index.php';
    header("Location: $redirect_url");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            min-height: 100vh;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c63ff, #33d9b2);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            margin: 0 auto 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="profile-card col-md-6">
            <div class="text-center">

                <div class="profile-avatar">
                    <?php echo strtoupper(substr($user['nom'], 0, 1)) ?>
                </div>
                <h2><?php echo $user['nom']; ?></h2>
                <p class="text-muted"><?php echo $user['email']; ?></p>
            </div>
            <!-- redirect_url -->
            <form method="POST" class="mt-4">
                <input type="hidden" name="redirect_url"
                    value="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; ?>">

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['nom']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                        value="<?php echo $user['telephone']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse"
                        value="<?php echo $user['adresse']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; ?>"
                    class="btn btn-secondary mt-3 w-100">Retour</a>
            </form>
        </div>
    </div>
</body>

</html>