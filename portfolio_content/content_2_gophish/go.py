import requests

# Configuration
api_key = 'notre clef api'
addresse = "notre adresse"
GOPHISH_API_KEY = api_key
GOPHISH_BASE_URL = addresse 

# Fonction pour tester la connexion à l'API
def tester_connexion():
    url = f"{GOPHISH_BASE_URL}/api/campaigns/"
    headers = {
        "Authorization": f"Bearer {GOPHISH_API_KEY}",
        "Content-Type": "application/json"
    }
    
    try:
        response = requests.get(url, headers=headers, verify=False)  # verify=False si le SSL n'est pas configuré
        
        if response.status_code == 200:
            print("Connexion réussie à l'API Gophish!")
            print("Données reçues:", response.json())
        else:
            print(f"Erreur lors de la connexion à l'API: {response.status_code}")
            print(response.text)
    except Exception as e:
        print("Une erreur est survenue:", e)

# Fonction pour valider les IDs des groupes, modèles d'email et pages de capture
# J'avais créé ça pour vérifier que je mettais bien des choses qui existent dans ma fonction
def valider_ids():
    headers = {
        "Authorization": f"Bearer {GOPHISH_API_KEY}",
        "Content-Type": "application/json"
    }

    # Vérifier les groupes
    print("Validation des groupes disponibles:")
    try:
        response = requests.get(f"{GOPHISH_BASE_URL}/api/groups/", headers=headers, verify=False)
        if response.status_code == 200:
            print("Groupes:")
            for group in response.json():
                print(f"ID: {group['id']}, Nom: {group['name']}")
        else:
            print(f"Erreur lors de la récupération des groupes: {response.status_code}")
            print(response.text)
    except Exception as e:
        print("Une erreur est survenue lors de la récupération des groupes:", e)

    # Vérifier les modèles d'email
    print("\nValidation des modèles d'email disponibles:")
    try:
        response = requests.get(f"{GOPHISH_BASE_URL}/api/templates/", headers=headers, verify=False)
        if response.status_code == 200:
            print("Modèles d'email:")
            for template in response.json():
                print(f"ID: {template['id']}, Nom: {template['name']}")
        else:
            print(f"Erreur lors de la récupération des modèles d'email: {response.status_code}")
            print(response.text)
    except Exception as e:
        print("Une erreur est survenue lors de la récupération des modèles d'email:", e)

    # Vérifier les pages de capture
    print("\nValidation des pages de capture disponibles:")
    try:
        response = requests.get(f"{GOPHISH_BASE_URL}/api/pages/", headers=headers, verify=False)
        if response.status_code == 200:
            print("Pages de capture:")
            for page in response.json():
                print(f"ID: {page['id']}, Nom: {page['name']}")
        else:
            print(f"Erreur lors de la récupération des pages de capture: {response.status_code}")
            print(response.text)
    except Exception as e:
        print("Une erreur est survenue lors de la récupération des pages de capture:", e)

# Fonction pour créer une campagne
def creer_campagne(nom_campagne, groupe_cible_id, modele_smtp_id, modele_email_id, page_capture_id):
    url = f"{GOPHISH_BASE_URL}/api/campaigns/"
    headers = {
        "Authorization": f"Bearer {GOPHISH_API_KEY}",
        "Content-Type": "application/json"
    }
    
    # Structure du payload
    payload = {
        "name": nom_campagne,
        "groups":[{"name":groupe_cible_id}],  # Tableau d'IDs de groupes
        "template":{"name":modele_email_id},   # ID du modèle d'email
        "smtp":{"name": modele_smtp_id},       #ID de SMTP
        "page":{"name":page_capture_id},  # ID de la page de capture
        "url":"http://www.phishing.rubis-energy.com/"        # URL de redirection (jsp ce que ça veut dire mais c'est dans le payload)
    }
    
    # Affichage pour débug
    print("Payload envoyé :", payload)
    
    try:
        response = requests.post(url, headers=headers, json=payload, verify=False)
        if response.status_code == 201:
            print("Campagne créée avec succès!")
            print("Détails de la campagne:", response.json())
        else:
            print(f"Erreur lors de la création de la campagne: {response.status_code}")
            print(response.text)
    except Exception as e:
        print("Une erreur est survenue lors de la création de la campagne:", e)