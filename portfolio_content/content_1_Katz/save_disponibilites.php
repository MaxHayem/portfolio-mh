<?php
require './components/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$typeDisponibilite = $_POST['type_disponibilite'];
$dateSpecifique = $_POST['date_specifique'] ?? null;
$heureDebut = $_POST['heure_debut'] ?? null;
$heureFin = $_POST['heure_fin'] ?? null;
$mois = $_POST['mois'] ?? null;
$jours = $_POST['jours'] ?? [];  // Récupérer les jours (tableau)

if (!empty($jours)) {
    foreach ($jours as $jour) {
        $sql = "INSERT INTO disponibilite (user_id, type_disponibilite, date_specifique, jour_semaine, heure_debut, heure_fin, mois) 
                VALUES (:user_id, :type_disponibilite, :date_specifique, :jour_semaine, :heure_debut, :heure_fin, :mois)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':type_disponibilite' => $typeDisponibilite,
            ':date_specifique' => $dateSpecifique,
            ':jour_semaine' => $jour,
            ':heure_debut' => $heureDebut,
            ':heure_fin' => $heureFin,
            ':mois' => $mois
        ]);
        
        if ($stmt->errorCode() != 0) {
            die(implode(" ", $stmt->errorInfo()));
        }
    }
    echo "Disponibilités enregistrées avec succès !";
} else {
    echo "Veuillez sélectionner au moins un jour.";
}

?>
