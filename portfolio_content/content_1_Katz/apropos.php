<?php
    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left');
    $navbar->AddItem('Accueil','index.php','center' );
    $navbar->AddItem('Nos service','service.php', 'center'); 
    $navbar->AddItem('contact','contact.php','center');
    $navbar->AddItem('A propos','apropos.php','center', true);
    $navbar->AddItem('Connexion','login.php','right');
    $navbar->AddItem('Inscription','register.php','right');
    
    $navbar->render() ;
    
?>


<section  class="about">
        <h2>À propos de nous</h2>
        <p>Depuis plus de 10 ans, TPro aide ses clients à résoudre leurs problèmes techniques rapidement et efficacement. Nos experts qualifiés sont disponibles 24h/24 pour répondre à vos besoins.</p>
    </section>


<?php
     require './components/footer.php';
?>