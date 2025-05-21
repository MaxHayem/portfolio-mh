<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #1e1e1e;
            color: #f5f5f5;
        }
        button {
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
    <h1 style="text-align: center;">Inscription</h1>

    <?php
    // Inclusion du fichier de connexion à la base de données
    include "connect.php";

    // Vérification si le formulaire a été soumis
    if (isset($_POST['inscr'])) {
        // Récupération des données du formulaire
        $nom = mysqli_real_escape_string($id, trim($_POST['nom']));
        $prenom = mysqli_real_escape_string($id, trim($_POST['prenom']));
        $mail = mysqli_real_escape_string($id, trim($_POST['mail']));
        $password = mysqli_real_escape_string($id, trim($_POST['password']));

        // Vérification si l'email existe déjà
        $checkMailQuery = "SELECT * FROM user WHERE mail = '$mail'";
        $checkMailResult = mysqli_query($id, $checkMailQuery);

        if (mysqli_num_rows($checkMailResult) > 0) {
            // Si l'email existe déjà
            echo "<div class='message error'>Cet email est déjà utilisé. Veuillez en choisir un autre.</div>";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion des données dans la base
            $insertQuery = "INSERT INTO user (nom, prenom, mail, password) VALUES ('$nom', '$prenom', '$mail', '$hashedPassword')";
            if (mysqli_query($id, $insertQuery)) {
                echo "<div class='message success'>Inscription réussie ! Vous pouvez maintenant vous connecter.</div>";
            } else {
                echo "<div class='message error'>Erreur lors de l'inscription. Veuillez réessayer plus tard.</div>";
            }
        }
    }
    if (isset($_POST['conn'])) {
        header("Location: index.php");
        exit;
    }
    ?>

    <form action="" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="mail">Email :</label>
        <input type="email" id="mail" name="mail" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="inscr">S'inscrire</button>
    </form><br>
    <form action="" method="post">
        <button type="submit" name="conn">Déjà inscrit ? Connectez-vous</button>
    </form>
</body>
</html>