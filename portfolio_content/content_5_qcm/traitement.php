<?php
session_start();
echo "Bonjour ".$_SESSION['user_prenom'];
?>
<pre>
    <a href="deconnexion.php">Deconnexion</a>
    <?php
    // Initialisation de la variable pour stocker la note
    $note = 0;

    // Inclusion du fichier de connexion à la base de données
    include "connect.php";

    // Début de l'affichage des résultats avec un style général
    echo "<div style='font-family: Arial, sans-serif; margin: 20px; background-color: #1e1e1e; color: #f5f5f5; padding: 20px; border-radius: 8px;'>";
    echo "<h1 style='color: #4caf50; text-align: center;'>Résultats du QCM</h1>";
    echo "<hr style='border-color: #4caf50;'>";

    // Parcours de toutes les réponses envoyées via le formulaire ($_POST)
    foreach ($_POST as $key => $value) {
        // Requête pour vérifier si la réponse sélectionnée est correcte
        $req = "SELECT * FROM reponses WHERE idr = $value AND verite = 1";
        $result = mysqli_query($id, $req);

        // Si la réponse est correcte
        if (mysqli_num_rows($result) == 1) {
            // Ajouter 2 points à la note
            $note += 2;
        } else {
            // Si la réponse est incorrecte, récupérer le libellé de la question
            $questionQuery = "SELECT libelleQ FROM questions WHERE idq = $key";
            $questionResult = mysqli_query($id, $questionQuery);
            $question = mysqli_fetch_assoc($questionResult)['libelleQ'];

            // Récupérer le libellé de la bonne réponse
            $correctAnswerQuery = "SELECT libeller FROM reponses WHERE idq = $key AND verite = 1";
            $correctAnswerResult = mysqli_query($id, $correctAnswerQuery);
            $correctAnswer = mysqli_fetch_assoc($correctAnswerResult)['libeller'];

            // Afficher un message d'erreur dans une bulle
            echo "<div style='margin-bottom: 20px; padding: 20px; background-color: #2e2e2e; color: #ff6b6b; border: 1px solid #ff6b6b; border-radius: 15px; max-width: 600px; margin: 10px auto;'>";
            echo "<strong>Question :</strong> $question<br>";
            echo "<strong>Bonne réponse :</strong> $correctAnswer";
            echo "</div>";
        }
    }

    // Afficher la note finale dans une bulle
    echo "<div style='margin-top: 30px; padding: 20px; background-color: #2e2e2e; color: #4caf50; border: 1px solid #4caf50; border-radius: 15px; max-width: 600px; margin: 20px auto; text-align: center;'>";
    echo "<strong>Votre note est de :</strong> $note / 20";
    echo "</div>";

    // Fin de l'affichage des résultats
    echo "</div>";
    ?>
</pre>