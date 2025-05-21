<?php
session_start();
if(isset($_POST["bout"])){
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    include 'connect.php';
    $req = "select * from user where mail='$mail' and mdp='$mdp'";
    $resultat = mysqli_query($id, $req);
    if(mysqli_num_rows($resultat)>0){
        $ligne = mysqli_fetch_assoc($resultat);
        $_SESSION["mail"]=$mail;
        $_SESSION["nom"]=$ligne["nom"];
        $_SESSION["prenom"]=$ligne["prenom"];
        $_SESSION["role"]=$ligne["role"];
        $_SESSION["idu"]=$ligne["idu"];

        header("location:chat.php");
    }else{
        echo "Erreur de login ou de mot de passe!!!";
    }
}
if(isset($_POST["insc"])){
    header("location:inscription.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulaire de connexion</h1><hr>
    <form action="" method="post">
        <input type="email" name="mail" placeholder="Login/Mail :" required><br><br>
        <input type="password" name="mdp" placeholder="Mot de passe :" required><br><br>
        <input type="submit" value="Connexion" name="bout">
    </form><hr>
    <form action="" method="post">
        <input type="submit" value="S'inscrire" name="insc">
    </form><hr>
</body>
</html>