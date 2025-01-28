
<?php
    require './components/header.php';
    require './class/navbar.php';

$navbar = new Navbar();
$navbar->AddItem('TPro','index.php', 'left');
$navbar->AddItem('Accueil','index.php','center' ,true);
$navbar->AddItem('Nos services','service.php', 'center'); 
$navbar->AddItem('Contact','contact.php','center');
$navbar->AddItem('A propos','apropos.php','center');
$navbar->AddItem('Connexion','login.php','right');
$navbar->AddItem('Inscription','register.php','right');

$navbar->render() ;
?>
<!-- Hero Section -->
<link rel="stylesheet" href="./components/style.css">  
<section class="hero">
  <div class="hero-text">
    <h1>Trouvez le bon professionnel, facilement</h1>
    <p>
      Connectez-vous avec les meilleurs experts ou proposez vos services à des particuliers. Une plateforme simple, rapide et efficace.
    </p>
    <a href="apropos.php"><button>Commencez maintenant</button></a>
  </div>
  <div class="hero-image">
    <img src="https://via.placeholder.com/400x300" alt="Image de mise en relation">
  </div>
</section>
<script src="index.js"></script>
  <?php
    require './components/footer.php';
?>
