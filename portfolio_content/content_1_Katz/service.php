<?php
    require './components/header.php';
    require './class/navbar.php';

    $navbar = new Navbar();
    $navbar->AddItem('TPro','index.php', 'left');
    $navbar->AddItem('Accueil','index.php','center');
    $navbar->AddItem('Nos service','service.php', 'center', true); 
    $navbar->AddItem('contact','contact.php','center');
    $navbar->AddItem('A propos','apropos.php','center');
    $navbar->AddItem('Connexion','login.php','right');
    $navbar->AddItem('Inscription','register.php','right');
    
    $navbar->render() ;
?>

    <link rel="stylesheet" href="./components/service.css">
    <section class="sersection">
        <header class="header_2">
            <div class="container">
                <h1>Dépannage Express</h1>
                <p>Votre solution rapide pour tous vos problèmes techniques</p>
                
            </div>
        </header>
        <section  class="services">
            <h2>Nos Services</h2>
                </br></br>
            <div class="service-container">
                <div class="service">
                    <img src="https://www.aventure-travaux.com/wp-content/uploads/2024/07/158270-580d2245-0497-4a7f-bc32-5aac0279a8f3_1.jpg" alt="Plomberie">
                    <h3>Plomberie</h3>
                    <p>Réparation de fuites, installation de sanitaires, dépannage urgent.</p>
                </div>
                <div class="service">
                    <img src="https://www.iris-st.org/medias/6/Electricien-freepick-1920x1280.jpg" alt="Électricité">
                    <h3>Électricité</h3>
                    <p>Réparation de pannes, installation de circuits, maintenance électrique.</p>
                </div>
                <div class="service">
                    <img src="https://luxicts.lu/wp-content/uploads/2022/09/AdobeStock_529778101-1024x683.jpeg" alt="Informatique">
                    <h3>Informatique</h3>
                    <p>Dépannage PC, installation de logiciels, récupération de données.</p>
                </div>
                <div class="service">
                    <img src="https://menagenrj.ca/wp-content/uploads/2024/05/entretien-menager-commercial.jpg" alt="Ménage">
                    <h3>Ménage</h3>
                    <p>Services de nettoyage pour particuliers et professionnels.</p>
                </div>
            </div>
        </section>
    </section>    
    <script src="./components/service.js"></script>


<?php
     require './components/footer.php';
?>