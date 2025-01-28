<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'telos';
$username = 'root'; // Change selon ton setup
$password = '';     // Change selon ton setup

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

session_start();

// Empêcher la mise en cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");



// Vérification de l'utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login_pro.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Traitement du formulaire pour ajouter une compétence
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_competence = $_POST['nom_competence'];
    $niveau = $_POST['niveau'];

    if (!empty($nom_competence) && !empty($niveau)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO competences (user_id, nom_competence, niveau) VALUES (:user_id, :nom_competence, :niveau)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':nom_competence' => $nom_competence,
                ':niveau' => $niveau
            ]);
            $success_message = "Compétence ajoutée avec succès.";
        } catch (Exception $e) {
            $error_message = "Une erreur s'est produite lors de l'ajout de la compétence.";
        }
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}

// Récupérer les compétences existantes de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM competences WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$competences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left'); 
    $navbar->AddItem('Profil','profil.php', 'center');
    $navbar->AddItem('Tableau de bord','dashboard_pro.php','center' );
    $navbar->AddItem('Disponibilités','disponibilite.php','center');
    $navbar->AddItem('Compétences','competence.php','center',true);
    $navbar->AddItem('Agenda','agenda.php','center');
    $navbar->AddItem('Déconnexion', 'javascript:location.replace("logout.php")','right');    
    
    $navbar->render() ;
?>
    <link rel="stylesheet" href="./components/competence.css">
    <title>Compétences</title>
    <div class="container-competence">    
        <br>
        <h1>Ajouter des Compétences</h1>

        <!-- Messages de retour -->
        <?php if ($error_message): ?>
            <div class="messages error"><?= htmlspecialchars($error_message) ?></div>
        <?php elseif ($success_message): ?>
            <div class="messages success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout de compétences -->
        <form method="post">
            <label for="nom_competence">Nom de la compétence :</label>
            <input type="text" id="nom_competence" name="nom_competence" placeholder="Exemple : Électricité" required>

            <label for="niveau">Niveau :</label>
            <select id="niveau" name="niveau" required>
                <option value="">Sélectionner un niveau</option>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
            </select>

            <button type="submit">Ajouter la compétence</button>
        </form>

        <!-- Liste des compétences existantes -->
        <div class="competences-list">
            <h2>Mes Compétences</h2>
            <?php if (count($competences) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de la compétence</th>
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
                <p>Aucune compétence ajoutée.</p>
            <?php endif; ?>
        </div>
    </div>
<?php
require './components/footer.php';
?>
