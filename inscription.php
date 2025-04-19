<?php
session_start();
include('db_connect.php'); // Inclure la configuration de la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $role = 'utilisateur';

    // Vérifier si l'email existe déjà
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Cet email est déjà utilisé.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur dans la base de données
        $sql = "INSERT INTO users (nom, email, telephone, adresse, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nom, $email, $telephone, $adresse, $mot_de_passe_hache, $role);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header('Location: authentification.php');
            exit();
        } else {
            $error = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, rgb(104, 143, 207), rgb(135, 148, 163));
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Conteneur principal de la page d'inscription */
        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Titre */
        h2 {
            font-weight: bold;
            color: rgb(25, 17, 177);
            margin-bottom: 30px;

            text-align: center;
        }



        /* Message d'erreur */
        .error {
            color: #ff4d4d;
            background-color: #ffe6e6;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="text-center">Inscription</h2>
        <?php if (isset($error)) {
            echo '<div class="error">' . $error . '</div>';
        } ?>
        <form action="inscription.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="nom" placeholder="Nom complet" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="telephone" placeholder="Téléphone" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="adresse" placeholder="Adresse" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
        </form>
        <p class="mt-3 text-center ">Déjà inscrit ? <a href="authentification.php">Connectez-vous</a></p>
    </div>
</body>

</html>