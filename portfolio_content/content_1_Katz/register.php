<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "telos";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Initialisation des variables
$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $mot_de_passe_confirm = $_POST['mot_de_passe_confirm'];

    // Vérification que les mots de passe correspondent
    if ($mot_de_passe !== $mot_de_passe_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Hachage du mot de passe
        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Insertion dans la base de données
        $sql = "INSERT INTO users_pro (nom, prenom, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nom, $prenom, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de l'inscription. Veuillez réessayer.";
        }

        $stmt->close();
    }
}

// Fermer la connexion
$conn->close();
?>

<?php
    include './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left');
    $navbar->AddItem('Accueil','index.php','center' ,true);
    $navbar->AddItem('Nos service','service.php', 'center'); 
    $navbar->AddItem('contact','contact.php','center');
    $navbar->AddItem('A propos','apropos.php','center');
    $navbar->AddItem('Connexion','login.php','right');
    $navbar->AddItem('Inscription','register.php','right');
    
    $navbar->render() ;
?>

<link rel="stylesheet" href="./components/register.css">
    <title>Inscription - Mon Application</title>

<div class="container-register">
    <h1>Inscription</h1>

    <!-- Affichage des erreurs ou du succès -->
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Formulaire d'inscription -->
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" placeholder="Nom" required>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <label for="societe">Vous êtes une sociéte, cochez cette case :</label>
        <input type="checkbox" id="checkbox_pro" name="societe" onclick="toggleInput()">       
        <input type="text" id="societe_nom" placeholder="Entrez le nom de votre société" class="societe_nom">
        <label>Mail :</label>
        <input type="email" name="email" placeholder="Email" required>
        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <label>Confirmer votre mot de passe :</label>
        <input type="password" name="mot_de_passe_confirm" placeholder="Confirmer le mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
</div>
<script src="./components/register.js"></script>

<?php
    require './components/footer.php';
    ?>

