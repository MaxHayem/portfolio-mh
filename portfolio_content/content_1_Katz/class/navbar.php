<?php
class Navbar {
    private $leftItems = [];  
    private $centerItems = [];
    private $rightItems = [];

    // Ajouter les éléments à une section spécifique
    public function AddItem($name, $link, $section = 'left', $active = false) {
        $item = [
            'name' => $name,
            'link' => $link,
            'active' => $active,
            'onclick' => null
        ];

        // Détecter si c'est un lien javascript et préparer l'attribut onclick
        if (strpos($link, 'javascript:') === 0) {
            $item['onclick'] = str_replace('javascript:', '', $link);
            $item['link'] = '#';  // Lien neutre pour ne pas recharger la page
        }

        // Ajouter à la bonne section
        if ($section === 'center') {
            $this->centerItems[] = $item; 
        } elseif ($section === 'right') {
            $this->rightItems[] = $item;
        } else {
            $this->leftItems[] = $item;
        }
    }

    // Générer la navbar avec les sections
    public function render() {
        echo '<nav class="navbar">';       
        echo '<div class="navbar-section left">';
        $this->renderItems($this->leftItems);
        echo '</div>';

        echo '<div class="navbar-section center">';
        $this->renderItems($this->centerItems);        
        echo '</div>';

        echo '<div class="navbar-section right">';
        $this->renderItems($this->rightItems);
        echo '</div>';        
        echo '</nav>';
    }        

    // Générer les items d'une section
    private function renderItems($items) {
        echo '<ul class="navbar-list">';
        foreach ($items as $item) {
            $activeClass = $item['active'] ? 'active' : '';
            echo '<li class="navbar-item ' . $activeClass . '">';
            
            // Vérifier si un onclick est défini
            if ($item['onclick']) {
                echo '<a href="#" onclick="' . htmlspecialchars($item['onclick']) . '">' . $item['name'] . '</a>';
            } else {
                echo '<a href="' . htmlspecialchars($item['link']) . '">' . $item['name'] . '</a>';
            }
            
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
