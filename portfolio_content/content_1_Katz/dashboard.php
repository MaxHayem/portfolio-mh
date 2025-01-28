<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Empêcher la mise en cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Connexion à la base de données
require './components/db_connect.php'; 


// Récupérer les données des tables
$sql_users = "SELECT * FROM users_pro";
$sql_competences = "SELECT * FROM competences";
$sql_disponibilite = "SELECT * FROM disponibilite";

$result_users = $conn->query($sql_users);
$result_competences = $conn->query($sql_competences);
$result_disponibilite = $conn->query($sql_disponibilite);

    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left');
    $navbar->AddItem('Accueil','index.php','center');
    $navbar->AddItem('Nos service','service.php', 'center'); 
    $navbar->AddItem('contact','contact.php','center');
    $navbar->AddItem('A propos','apropos.php','center');
    $navbar->AddItem('Déconnexion','javascript:location.replace("logout.php")','right');
    
    $navbar->render() ;
?>


    <title>Dashboard - Mes Données</title>
    <link rel="stylesheet" href="./components/dashboard.css">


<h1 class="htdb">Tableau de bord - DATABASE telos</h1>
<div class="container-admin">
    <h2>Users Pro</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Date d'inscription</th>
        </tr>
        <?php if ($result_users->num_rows > 0): ?>
            <?php while ($row = $result_users->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['date_inscription'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Aucun utilisateur trouvé.</td></tr>
        <?php endif; ?>
    </table>

    <h2>Compétences</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Nom Compétence</th>
            <th>Niveau</th>
        </tr>
        <?php if ($result_competences->num_rows > 0): ?>
            <?php while ($row = $result_competences->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['competence_id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['nom_competence'] ?></td>
                    <td><?= $row['niveau'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">Aucune compétence trouvée.</td></tr>
        <?php endif; ?>
    </table>

    <h2>Disponibilités</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Type</th>
            <th>Date</th>
            <th>Jour</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Mois</th>
        </tr>
        <?php if ($result_disponibilite->num_rows > 0): ?>
            <?php while ($row = $result_disponibilite->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['disponibilite_id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['type_disponibilite'] ?></td>
                    <td><?= $row['date_specifique'] ?></td>
                    <td><?= $row['jour_semaine'] ?></td>
                    <td><?= $row['heure_debut'] ?></td>
                    <td><?= $row['heure_fin'] ?></td>
                    <td><?= $row['mois'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">Aucune disponibilité trouvée.</td></tr>
        <?php endif; ?>
    </table>
</div>

<?php
    require './components/footer.php';
?>
    
