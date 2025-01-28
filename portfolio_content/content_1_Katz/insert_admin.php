<?php
exit();
/*AJOUTER UN ADMINISTRATEUR; ATTENTION A LA SECURITE !!!!*/

/*

$servername = "localhost"; // Nom de ton serveur
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "telos"; // Nom de ta base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Hachage du mot de passe administrateur
$admin_username = "YHC_admin"; // Nom d'utilisateur de l'admin
$admin_password = "Yaacov2790."; // Remplace par ton mot de passe
$hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

// Insertion de l'administrateur
$sql = "INSERT INTO admin_users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $admin_username, $hashed_password);

if ($stmt->execute()) {
    echo "Administrateur ajouté avec succès !";
} else {
    echo "Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();


?>
