<?php
session_start();
unset($_SESSION['loggedin']);

// Connexion à la base de données
require './components/db_connect.php';

// Traitement du formulaire
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];  // Email ou nom d'utilisateur
    $password = $_POST['password'];

    // Détection du type d'utilisateur (admin ou utilisateur pro)
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        // C'est un email -> connexion utilisateur pro
        $sql = "SELECT * FROM users_pro WHERE email = ?";
    } else {
        // Sinon, c'est un admin
        $sql = "SELECT * FROM admin_users WHERE username = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'] ?? $user['mot_de_passe'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'] ?? $user['email'];
        $_SESSION['role'] = isset($user['role']) ? $user['role'] : 'admin';
        $_SESSION['user_id'] = $user['user_id'] ?? null;

        // Redirection en fonction du rôle
        $redirectPage = (isset($user['role']) && $user['role'] === 'user') ? 'dashboard_pro.php' : 'dashboard.php';
        header("Location: $redirectPage");
        exit();
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }

    $stmt->close();
    $conn->close();
}

require './components/header.php';
require './class/navbar.php';

$navbar = new Navbar();
$navbar->AddItem('TPro','index.php', 'left');
$navbar->AddItem('Accueil','index.php','center' ,true);
$navbar->AddItem('Nos services','service.php', 'center'); 
$navbar->AddItem('Contact','contact.php','center');
$navbar->AddItem('À propos','apropos.php','center');
$navbar->AddItem('Connexion','login.php','right');
$navbar->AddItem('Inscription','register.php','right');
$navbar->render();
?>

<link rel="stylesheet" href="./components/login.css">
<title>Connexion</title>

<div class="login-container">
    <h2>Connexion</h2>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <!-- Formulaire unique -->
    <form method="POST">
        <input type="text" name="login" placeholder="Email ou Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</div>

<?php require './components/footer.php'; ?>
