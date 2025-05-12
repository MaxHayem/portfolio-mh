<?php
include 'connect.php';
$req = "select * from msg";
$resultat = mysqli_query($id,$req);

while($ligne = mysqli_fetch_assoc($resultat)){

    echo $ligne["pseudo"]." ".$ligne["message"]." ".
            $ligne["date"]."<br>";
}
?>