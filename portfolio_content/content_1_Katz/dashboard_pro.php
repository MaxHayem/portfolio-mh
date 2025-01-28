<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: login_pro.php");
    exit();
}

// Empêcher la mise en cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Connexion à la base de données
require './components/db_connect.php';


// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom, prenom, email, date_inscription FROM users_pro WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Récupérer les compétences de l'utilisateur
$sql_competences = "SELECT nom_competence, niveau FROM competences WHERE user_id = ?";
$stmt_competences = $conn->prepare($sql_competences);
$stmt_competences->bind_param("i", $user_id);
$stmt_competences->execute();
$result_competences = $stmt_competences->get_result();
$competences = $result_competences->fetch_all(MYSQLI_ASSOC);

// Récupérer les disponibilités existantes de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM disponibilite WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$disponibilités = $result->fetch_all(MYSQLI_ASSOC);


// Fermer les connexions
$stmt->close();
$stmt_competences->close();
$conn->close();

    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left'); 
    $navbar->AddItem('Profil','profil.php', 'center');
    $navbar->AddItem('Tableau de bord','dashboard_pro.php','center' ,true);
    $navbar->AddItem('Disponibilités','disponibilite.php','center');
    $navbar->AddItem('Compétences','competence.php','center');
    $navbar->AddItem('Agenda','agenda.php','center');
    $navbar->AddItem('Déconnexion', 'javascript:location.replace("logout.php")','right');    
    
    $navbar->render() ;
?>
    <link rel="stylesheet" href="./components/dashboard_pro.css">
    <title>Tableau de bord</title>

<div class="container-dashboard">
    <h1>Bienvenue, <?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?> !</h1>
    <p>Vous êtes connecté en tant qu'utilisateur Pro.</p>
   

    <div class="competences">
        <h2>Vos compétences</h2>
        <?php if (count($competences) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Compétence</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competences as $competence): ?>
                        <tr>
                            <td><?= htmlspecialchars($competence['nom_competence']) ?></td>
                            <td><?= htmlspecialchars($competence['niveau']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune compétence ajoutée pour le moment.</p>
        <?php endif; ?>
    </div>
    <div class="disponibilite">
        <h2>Vos disponibilités</h2>
        <?php if (count($disponibilités) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Type</th>
                        <th>Jour de la semaine</th>
                        <th>Heure de debut</th>
                        <th>Heure de fin</th>
                        <th>Date specifique</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disponibilités as $dispo): ?>
                        <tr>
                            <td><?= htmlspecialchars($dispo['mois']) ?></td>
                            <td><?= htmlspecialchars($dispo['type_disponibilite']) ?></td>
                            <td><?= htmlspecialchars($dispo['jour_semaine']) ?></td>
                            <td><?= htmlspecialchars($dispo['heure_debut']) ?></td>
                            <td><?= htmlspecialchars($dispo['heure_fin']) ?></td>
                            <td><?= htmlspecialchars($dispo['date_specifique']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune disponibilité ajoutée pour le moment.</p>
        <?php endif; ?>
    </div>

    
</div>


<?php
     require './components/footer.php';
?>