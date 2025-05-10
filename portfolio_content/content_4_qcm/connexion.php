<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #f5f5f5;
            margin: 20px;
        }
        form {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #1e1e1e;
            color: #f5f5f5;
        }
        button, a {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin: 20px auto;
            padding: 10px;
            border-radius: 5px;
            max-width: 400px;
        }
        .success {
            background-color: #2e7d32;
            color: #ffffff;
        }
        .error {
            background-color: #c62828;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Connexion</h1>

    <?php
    // Inclusion du fichier de connexion à la base de données
    include "connect.php";

   

    // Vérification si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $mail = mysqli_real_escape_string($id, trim($_POST['mail']));
        $password = trim($_POST['password']);

        // Vérification si l'utilisateur existe
        $query = "SELECT * FROM user WHERE mail = '$mail'";
        $result = mysqli_query($id, $query);

        if (mysqli_num_rows($result) === 1) {
            // Récupération des données de l'utilisateur
            $user = mysqli_fetch_assoc($result);

            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // Connexion réussie, stockage des informations dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                
                echo "<div class='message success'>Connexion réussie ! Bienvenue, " . htmlspecialchars($user['prenom']) . ".</div>";
                header("refresh:2;url=qcm.php");
            } else {
                // Mot de passe incorrect
                echo "<div class='message error'>Mot de passe incorrect. Veuillez réessayer.</div>";
            }
        } else {
            // Email non trouvé
            echo "<div class='message error'>Aucun compte trouvé avec cet email.</div>";
        }
    }
    ?>

    <form action="" method="post">
        <label for="mail">Email :</label>
        <input type="email" id="mail" name="mail" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>