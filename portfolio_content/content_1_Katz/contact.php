<?php
    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left');
    $navbar->AddItem('Accueil','index.php','center');
    $navbar->AddItem('Nos service','service.php', 'center'); 
    $navbar->AddItem('contact','contact.php','center', true);
    $navbar->AddItem('A propos','apropos.php','center');
    $navbar->AddItem('Connexion','login.php','right');
    $navbar->AddItem('Inscription','register.php','right');
    
    $navbar->render() ;
?>

<section  class="contact">
    <h2>Contactez-nous</h2>
    <form id="contactForm">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" placeholder="Nom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" placeholder="email" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="4" placeholder="Entrez votre message" required></textarea>
        <div class="grille">
        <button type="submit">Envoyer</button>
        </div>
    </form>
</section>

<?php
     require './components/footer.php';
?>