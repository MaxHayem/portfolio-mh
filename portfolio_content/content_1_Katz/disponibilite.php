<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: login_pro.php");
    exit();
}
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
require './components/db_connect.php';


// Gestion de la soumission du formulaire

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id']; // Récupérer l'ID utilisateur depuis le formulaire
    $type_disponibilite = $_POST['type_disponibilite'];
    $date_specifique = $_POST['date_specifique'];
    $jour_semaine = $_POST['jour_semaine'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $mois = $_POST['mois'];


    // Vérifier si l'ID utilisateur existe dans la table users_pro
$stmt = $conn->prepare("SELECT * FROM users_pro WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Si l'utilisateur existe, on peut procéder à l'insertion
if ($result->num_rows > 0) {
    // L'utilisateur existe, insérer la disponibilité
    $sql = "INSERT INTO disponibilite (user_id, type_disponibilite, date_specifique, jour_semaine, heure_debut, heure_fin, mois) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssss', $user_id, $type_disponibilite, $date_specifique, $jour_semaine, $heure_debut, $heure_fin, $mois);
    
    if ($stmt->execute()) {
        $message = "Disponibilité ajoutée avec succès.";
    } else {
        $message = "Échec de l'ajout : " . $stmt->error;
    }
} else {
    $message = "L'utilisateur n'existe pas dans la base de données.";
}

$stmt->close();
   
}

// Récupérer les disponibilités existantes de l'utilisateur
$user_id = $_SESSION['user_id'];  // Utiliser la session pour récupérer l'ID utilisateur
$stmt = $conn->prepare("SELECT * FROM disponibilite WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$disponibilités = $result->fetch_all(MYSQLI_ASSOC);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result === false) {
        echo "Erreur SQL: " . $stmt->error;
    } else {
        $disponibilités = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    echo "Erreur lors de l'exécution de la requête: " . $stmt->error;
}

require './components/header.php';
require './class/navbar.php';

$navbar = new Navbar();
$navbar->AddItem('TPro','index.php', 'left'); 
$navbar->AddItem('Profil','profil.php', 'center');
$navbar->AddItem('Tableau de bord','dashboard_pro.php','center' );
$navbar->AddItem('Disponibilités','disponibilite.php','center',true);
$navbar->AddItem('Compétences','competence.php','center');
$navbar->AddItem('Agenda','agenda.php','center');
$navbar->AddItem('Déconnexion', 'javascript:location.replace("logout.php")','right');    

$navbar->render() ;
 
?>


<link rel="stylesheet" href="./components/disponibilite.css">
<title>Disponibilité</title>
<div class="container-dispo-grid">
<div class="container-disponibilite">
    <br>
    <h1>Ajouter une Disponibilité</h1>
    <?php if (isset($message)) { ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
        <?php } ?>
        
        <form method="POST" action="save_disponibilites.php">
            <div class="grid-form-dispo-1">      
            <label for="type_disponibilite">Type de disponibilité : </label>
            <select name="type_disponibilite" required>
                <option value="">-</option>
                <option value="Mensuelle">Mensuelle</option>
                <option value="Hebdomadaire">Hebdomadaire</option>
                <option value="Journalière">Journalière</option>
                <option value="Plage Horaire">Plage Horaire</option>
            </select><br><br>
            
            <label for="mois">Mois : </label>
            <select name="mois">
                <option value="">-</option>
                <option value="Janvier">Janvier</option>
                <option value="Février">Février</option>
                <option value="Mars">Mars</option>
                <option value="Avril">Avril</option>
                <option value="Mai">Mai</option>
                <option value="Juin">Juin</option>
                <option value="Juillet">Juillet</option>
                <option value="Août">Août</option>
                <option value="Septembre">Septembre</option>
                <option value="Octobre">Octobre</option>
                <option value="Novembre">Novembre</option>
                <option value="Décembre">Décembre</option>
            </select><br><br>
        
       <!-- <label for="jour_semaine">Jour de la semaine : </label>
        <select name="jour_semaine" multiple>
            <option value="">-</option>
            <option value="Lundi">Lundi</option>
            <option value="Mardi">Mardi</option>
            <option value="Mercredi">Mercredi</option>
            <option value="Jeudi">Jeudi</option>
            <option value="Vendredi">Vendredi</option>
            <option value="Samedi">Samedi</option>
            <option value="Dimanche">Dimanche</option>
        </select><br><br> -->

   
        <label for="date_specifique">Date spécifique : </label>
        <input type="date" name="date_specifique"><br><br>
        </div>

        <div class="grid-form-dispo-2">
            <label for="heure_debut">Horaire début : </label>
            <input type="time" name="heure_debut"><br><br>

            <label for="heure_fin">Horaire fin : </label>
            <input type="time" name="heure_fin"><br><br>
        </div>

        <label>Jours disponibles :</label>
        <div class="container-jours">
        <?php
        $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
        foreach ($jours as $jour) {
            echo "<label for='$jour'>$jour</label>";
            echo "<input type='checkbox' name='jours[]' value='$jour'>";
        }
        ?>
    </div>

        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <button type="submit" name="submit">Ajouter Disponibilité</button>
    </form>
</div>   
    <!-- Liste des disponibilités existantes -->
<div class="container-dispo_2">     
    <div class="disponibilite">
        <h2>Mes Dipsonibilités</h2>
        <?php if (count($disponibilités) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>type_disponibilite</th>
                        <th>mois</th>
                        <th>jour_semaine</th>
                        <th>heure_debut</th>
                        <th>heure_fin</th>
                        <th>date_specifique</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disponibilités as $dispo): ?>
                        <tr>
                            <td><?= htmlspecialchars($dispo['type_disponibilite']) ?></td>
                            <td><?= htmlspecialchars($dispo['mois']) ?></td>
                            <td><?= htmlspecialchars($dispo['jour_semaine']) ?></td>
                            <td><?= htmlspecialchars($dispo['heure_debut']) ?></td>
                            <td><?= htmlspecialchars($dispo['heure_fin']) ?></td>
                            <td><?= htmlspecialchars($dispo['date_specifique']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune compétence ajoutée.</p>
        <?php endif; ?>
    </div>
</div>
</div>

<?php require './components/footer.php'; ?>
