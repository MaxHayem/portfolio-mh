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
    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left'); 
    $navbar->AddItem('Profil','profil.php', 'center',true);
    $navbar->AddItem('Tableau de bord','dashboard_pro.php','center' );
    $navbar->AddItem('Disponibilités','disponibilite.php','center');
    $navbar->AddItem('Compétences','competence.php','center');
    $navbar->AddItem('Agenda','agenda.php','center');
    $navbar->AddItem('Déconnexion', 'javascript:location.replace("logout.php")','right');    
    
    $navbar->render() ;
?>
    <link rel="stylesheet" href="./components/profil.css">
    <title>Profil</title>
    
<div class="container-profil">
    <h2>Vos informations personnelles</h2>
    <br><br>
    <div class="info">
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Date d'inscription :</strong> <?= htmlspecialchars($user['date_inscription']) ?></p>
    </div>
</div>
    
<?php
    require './components/footer.php';
?>
