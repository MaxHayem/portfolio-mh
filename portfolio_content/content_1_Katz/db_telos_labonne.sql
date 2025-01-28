-- Créer la base de données
CREATE DATABASE telos;

-- Utiliser la base de données
USE telos;

-- Table : users_pro
CREATE TABLE users_pro (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
	role_pro VARCHAR(20) DEFAULT 'user'
);

-- Table : competences
CREATE TABLE competences (
    competence_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nom_competence VARCHAR(100) NOT NULL,
    niveau ENUM('Débutant', 'Intermédiaire', 'Avancé', 'Expert') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users_pro(user_id)
);

-- Table : disponibilite
CREATE TABLE disponibilite (
    disponibilite_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                         -- Référence vers l'utilisateur
    type_disponibilite ENUM('Mensuelle', 'Hebdomadaire', 'Journalière', 'Plage Horaire') NOT NULL,
    date_specifique DATE NULL,                    -- Utilisé pour une disponibilité spécifique (e.g., Journalière)
    jour_semaine ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NULL, 
                                                  -- Utilisé pour les disponibilités hebdomadaires
    heure_debut TIME NULL,                        -- Heure de début pour les plages horaires
    heure_fin TIME NULL,                          -- Heure de fin pour les plages horaires
    mois ENUM('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
              'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre') NULL, 
                                                  -- Utilisé pour les disponibilités mensuelles
    FOREIGN KEY (user_id) REFERENCES users_pro(user_id)
);


CREATE TABLE admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Le mot de passe sera haché
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	role_pro VARCHAR(20) DEFAULT 'admin'
);
