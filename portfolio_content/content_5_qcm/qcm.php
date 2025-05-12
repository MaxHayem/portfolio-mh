<?php
session_start();
if(!isset($_SESSION['user_nom'])) {
    header("Location: connexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCM - Tentez votre chance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #007BFF;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .question {
            margin-bottom: 15px;
        }
        .question input {
            margin-right: 10px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php

echo "Bonjour ".$_SESSION['user_prenom'];
?>
    <h1>Tentez votre chance</h1>
    <hr>
    <form action="traitement.php" method="post">
    <?php
    include "connect.php";
    $sql = "SELECT * FROM questions ORDER BY RAND() LIMIT 10";
    $result = mysqli_query($id, $sql);
    $cpt = 1;
    while ($ligne = mysqli_fetch_assoc($result)) {
        echo "<div class='question'>";
        echo "<strong>$cpt : $ligne[libelleQ]</strong><br>";
        $sql2 = "SELECT * FROM reponses WHERE idq = $ligne[idq] ORDER BY RAND()";
        $result2 = mysqli_query($id, $sql2);
        while ($ligne2 = mysqli_fetch_assoc($result2)) {
            echo "<input type='radio' name='$ligne[idq]' value='$ligne2[idr]' checked> $ligne2[libeller] <br>";
        }
        echo "</div>";
        $cpt++;
    }
    ?>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>