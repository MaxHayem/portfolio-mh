<?php
// Récupération de la date actuelle ou de la date demandée
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Calcul du premier jour du mois
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
// Nombre de jours dans le mois
$daysInMonth = date('t', $firstDayOfMonth);
// Premier jour de la semaine (0 = dimanche, 1 = lundi...)
$dayOfWeek = date('N', $firstDayOfMonth);

// Préparer les variables pour le mois précédent et suivant
$prevMonth = $month - 1;
$nextMonth = $month + 1;
$prevYear = $year;
$nextYear = $year;

if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear -= 1;
}
if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear += 1;
}
require './components/header.php';
require './class/navbar.php';
$navbar = new Navbar();
$navbar->AddItem('TPro','index.php', 'left'); 
$navbar->AddItem('Profil','profil.php', 'center');
$navbar->AddItem('Tableau de bord','dashboard_pro.php','center' );
$navbar->AddItem('Disponibilités','disponibilite.php','center');
$navbar->AddItem('Compétences','competence.php','center');
$navbar->AddItem('Agenda','agenda.php','center', true);
$navbar->AddItem('Déconnexion', 'javascript:location.replace("logout.php")','right');    

$navbar->render() ;

// Créer la grille de l'agenda
?>
    <title>Agenda - <?php echo date('F Y', $firstDayOfMonth); ?></title>
    <style>
      

.calendar-container {
    margin: 30px auto;
    width: 80%;
    max-width: 900px;
    background-color: white;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.calendar-header a {
    text-decoration: none;
    color: white;
    background-color: darkcyan;
    border-radius: 20px;
    padding: 10px;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    margin-top: 10px;
}
.day-name {
    background-color: sienna;
    color: white;
}

.day {
    background-color: lightskyblue;
}

.day-name, .day {
    padding: 15px;
    text-align: center;
    border: 1px solid #ddd;
    cursor: pointer;
}

.other-month {
    background-color: #bbb;
    color: white;
}

    </style>
    <div class="calendar-container">
        <h4>Tableau réutilisable pour afficher un visuel sur les disponibilités ou même pour sélectionner une date</h4>
        <div class="calendar-header">
            <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>"><!--&lt;--> Mois précédent</a>
            <h1><?php echo date('F Y', $firstDayOfMonth); ?></h1>
            <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">Mois suivant <!--&gt;--></a>
        </div>

        <div class="calendar-grid">
            <div class="day-name">Lun</div>
            <div class="day-name">Mar</div>
            <div class="day-name">Mer</div>
            <div class="day-name">Jeu</div>
            <div class="day-name">Ven</div>
            <div class="day-name">Sam</div>
            <div class="day-name">Dim</div>

            <?php
            // Afficher les jours du mois précédent
            $currentDay = 1;
            if ($dayOfWeek > 1) {
                $lastMonthDays = date('t', mktime(0, 0, 0, $month - 1, 1, $year));
                for ($i = $dayOfWeek - 1; $i > 0; $i--) {
                    echo '<div class="day other-month">' . ($lastMonthDays - $i + 1) . '</div>';
                }
            }

            // Afficher les jours du mois en cours
            for ($day = 1; $day <= $daysInMonth; $day++) {
                echo '<div class="day">' . $day . '</div>';
            }

            // Compléter avec les jours du mois suivant
            $remainingDays = (7 - (($daysInMonth + $dayOfWeek - 1) % 7)) % 7;
            for ($i = 1; $i <= $remainingDays; $i++) {
                echo '<div class="day other-month">' . $i . '</div>';
            }
            ?>
        </div>
    </div>
    
    <?php
    require './components/footer.php';
    ?>