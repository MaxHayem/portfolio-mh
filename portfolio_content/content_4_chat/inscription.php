<?php
include "connect.php";
if(isset($_POST["bout"])){
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];

    $req = "select * from user where mail = '$mail'";
    $res = mysqli_query($id, $req);
    //$row = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res) > 0){
        echo "ce mail existe deja";
        }else{
            $req = "insert into user (nom,prenom,mail,mdp,role)
                    values('$nom','$prenom','$mail','$mdp','1')";
            mysqli_query($id,$req);
            echo "inscription reussie, veuillez vous connecter....";
            header("refresh:3;url=connexion.php");
        }
}
if(isset($_POST["connexion"])){
    header("location:connexion.php");
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
    <h1>Formulaire d'inscription</h1><hr>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom :" required><br><br>
        <input type="text" name="prenom" placeholder="Prénom :" required><br><br>
        <input type="email" name="mail" placeholder="Email :" required><br><br>
        <input type="password" name="mdp" placeholder="Mot de passe :" required><br><br>
        <input type="file" name="avatar"><br><br>
        <input type="submit" value="S'inscrire" name="bout">
    </form><hr>
    <form action="connexion.php" method="post">
        <input type="submit" value="Déjà inscrit? Connectez-vous" name="connexion">
    </form><hr>
</body>
</html>