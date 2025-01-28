<?php
function renderSidebar() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Navbar Rétractable</title>
        <style>
            /* Style de base */
            body {
                margin: 0;
                font-family: Arial, sans-serif;
            }

            /* Navbar sur le côté */
            .sidebar {
                height: 100vh; /* Prend toute la hauteur de la fenêtre */
                width: 250px; /* Largeur de la barre */
                position: fixed; /* Fixée sur le côté gauche */
                top: 0;
                left: 0;
                background-color: #333; /* Couleur de fond */
                overflow-x: hidden; /* Cache le débordement horizontal */
                padding-top: 20px; /* Espacement supérieur */
                transition: 0.3s; /* Transition pour un effet fluide */
            }

            /* Style caché pour la barre */
            .sidebar.collapsed {
                width: 0; /* Réduction à 0 */
                padding-top: 0; /* Supprime l'espace */
            }

            /* Liens dans la barre */
            .sidebar a {
                padding: 15px 20px;
                text-decoration: none;
                font-size: 18px;
                color: white; /* Couleur du texte */
                display: block; /* Chaque lien sur une nouvelle ligne */
            }

            /* Changer la couleur au survol */
            .sidebar a:hover {
                background-color: #575757;
                color: #ffffff;
            }

            /* Bouton pour rétracter */
            .toggle-btn {
                position: absolute;
                top: 20px;
                left: 250px; /* Placé juste à côté de la barre */
                font-size: 18px;
                background-color: #333;
                color: white;
                border: none;
                padding: 10px 15px;
                cursor: pointer;
                transition: 0.3s;
            }

            /* Déplacement du bouton si la barre est rétractée */
            .toggle-btn.collapsed {
                left: 0;
            }

            /* Contenu principal */
            .main-content {
                margin-left: 250px; /* Laisser la place pour la barre */
                padding: 20px;
                transition: 0.3s; /* Transition fluide */
            }

            /* Ajustement du contenu lorsque la barre est rétractée */
            .main-content.collapsed {
                margin-left: 0;
            }
        </style>
    </head>
    <body>

        <!-- Barre de navigation -->
        <div class="sidebar" id="sidebar">
            <a href="#section1">Accueil</a>
            <a href="#section2">À propos</a>
            <a href="#section3">Services</a>
            <a href="#section4">Contact</a>
        </div>

        <!-- Bouton pour rétracter -->
        <button class="toggle-btn" id="toggle-btn">☰</button>

        <!-- Contenu principal -->
        <div class="main-content" id="main-content">
            <h1>Contenu principal</h1>
            <p>Ceci est le contenu principal de la page.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel quam a libero gravida lacinia.</p>
        </div>

        <!-- JavaScript -->
        <script>
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-btn');
            const mainContent = document.getElementById('main-content');

            toggleBtn.addEventListener('click', () => {
                // Toggle les classes "collapsed"
                sidebar.classList.toggle('collapsed');
                toggleBtn.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            });
        </script>

    </body>
    </html>
    <?php
}
?>
