<?php
session_start();
session_destroy();
echo "Vous allez être deconnecté !!!";
header("refresh:3;url=index.php");
?>