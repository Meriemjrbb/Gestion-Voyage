<?php
session_start();
include('db_connect.php');

// Vérification de l'envoi du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email1 = trim($_POST['email']);
    $mot_de_passe1 = trim($_POST['mot_de_passe']);

    // Préparation de la requête pour vérifier les informations de connexion
    $sql = "SELECT id, nom, email, mot_de_passe, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("s", $email1);
    $stmt->execute();
    $stmt->bind_result($id2, $nom2, $email2, $mot_de_passe2, $role2);

    if ($stmt->fetch()) {
        // Vérification du mot de passe haché
        if (password_verify($mot_de_passe1, $mot_de_passe2)) {
            // Connexion réussie
            $_SESSION['id'] = $id2;
            $_SESSION['nom'] = $nom2;
            $_SESSION['email'] = $email2;
            $_SESSION['role'] = $role2;

            if ($_SESSION['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $error = "mot de passe incorrect.";
        }
    } else {
        $error = "Email incorrect.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        /* Styles personnalisés */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg,rgb(104, 143, 207),rgb(135, 148, 163));
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            width: 100%;
            max-width: 550px;
            background-color: #ffffff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        h2 {
            font-size: 2.8rem;
            color: #333;
            margin-bottom: 30px;
        }

        .error,
        .success {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .error {
            color: #ff4d4d;
            background-color: #ffe6e6;
        }

        .success {
            color: #4CAF50;
            background-color: #e6ffe6;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h2 class="text-center">Connexion</h2>

        <!-- Affichage du message de succès -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="success"><?= $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); // Supprime le message une fois affiché ?>
        <?php endif; ?>

        <!-- Affichage du message d'erreur -->
        <?php if (isset($error)): ?>
            <div class="error"><?= $error; ?></div>
        <?php endif; ?>

        <form action="authentification.php" method="POST">
            <div class="mb-4">
                <input type="email" class="form-control" name="email" placeholder="Entrez votre email" required>
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" name="mot_de_passe" placeholder="Entrez votre mot de passe"
                    required>
            </div>
            <button type="submit" class="btn btn-success w-100">Se connecter</button>
        </form>
        <p class="mt-3 text-center">Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
    </div>
</body>

</html>