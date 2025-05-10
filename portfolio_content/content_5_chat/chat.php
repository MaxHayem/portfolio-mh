<?php
session_start();
if (!isset($_SESSION["mail"])) {
    header("location:connexion.php");
    exit;
}

$prenom = $_SESSION["prenom"];
$nom = $_SESSION["nom"];
$idu = $_SESSION["idu"];
$req = "";

echo "Bonjour $prenom,";

include 'connect.php';

if (isset($_POST["bout"])) {
    $message = mysqli_real_escape_string($id, $_POST["message"]);
    $destinataire = $_POST["destinataire"] === 'tous' ? 0 : (int)$_POST["destinataire"];

    $req = "INSERT INTO msg (pseudo, message, date, destinataire, idu)
            VALUES ('$prenom', '$message', NOW(), '$destinataire', '$idu')";
    mysqli_query($id, $req);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Box</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Chattez en direct! Chatbox
            <a href="deconnexion.php"><img src="quit.jfif" width="25"></a>
        </h1>
    </header>

    <div class="messages">
        <ul>
            <?php
            $req = "SELECT msg.*, user.prenom FROM msg
                    JOIN user ON msg.idu = user.idu
                    WHERE msg.destinataire = '$idu' OR msg.destinataire = 0 OR msg.idu = '$idu'
                    ORDER BY msg.date ASC";
                    
            $resultat = mysqli_query($id, $req);

            while ($ligne = mysqli_fetch_assoc($resultat)) {
                echo "<li class='message'>" . htmlspecialchars($ligne["date"]) . " - " . htmlspecialchars($ligne["prenom"]) . ": " . htmlspecialchars($ligne["message"]) . "</li>";
            }
            ?>
        </ul>
    </div>

    <div class="formulaire">
        <form action="" method="post">
            <input type="text" name="message" placeholder="Message :" required>

            <select name="destinataire">
                <option value="0" selected>Tous</option>
                <?php
                $req = "SELECT idu, prenom FROM user ORDER BY prenom";
                $resultat = mysqli_query($id, $req);

                while ($ligne = mysqli_fetch_assoc($resultat)) {
                    $disabled = ($idu == $ligne["idu"]) ? "disabled" : "";
                    echo "<option value='" . $ligne["idu"] . "' $disabled>" . htmlspecialchars($ligne["prenom"]) . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Envoyer" name="bout">
        </form>
    </div>
</div>

</body>
</html>
