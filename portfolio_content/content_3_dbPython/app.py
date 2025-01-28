from flask import Flask, render_template, jsonify
from flask_cors import CORS
import threading
import sqlite3

# Connexion à la base de données SQLite (création si elle n'existe pas)
conn = sqlite3.connect('todo.db')
cursor = conn.cursor()

# Création de la table "tasks" si elle n'existe pas déjà
cursor.execute('''
CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    description TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'Pending',
    completion INTEGER NOT NULL DEFAULT 0 CHECK (completion >= 0 AND completion <= 100),
    id_user INTEGER,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
    );
''')
conn.commit()

# Création de la table "users" si elle n'existe pas déjà
cursor.execute('''
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL           
)
''')
conn.commit()

conn.close()

app = Flask(__name__)

CORS(app)

# Function to fetch data from the database
def fetch_data1():
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM tasks")
    rows = cursor.fetchall()
    conn.close()
    return rows

def fetch_data2():
    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM users")
    rows = cursor.fetchall()
    conn.close()
    return rows

# Route to display the main page
@app.route('/')
def home():
    return render_template('index.html')

# API route to fetch table data
@app.route('/api/data1', methods=['GET'])
def get_data1():
    data = fetch_data1()
    return jsonify(data)  # Return the data as JSON

@app.route('/api/data2', methods=['GET'])
def get_data2():
    data = fetch_data2()
    return jsonify(data)  # Return the data as JSON

@app.route('/start_main', methods=['GET'])
def start_main():
    """Start the main function in a separate thread to avoid blocking the server."""
    thread = threading.Thread(target=main)
    thread.start()
    return jsonify({"status": "Task manager started!"})

if __name__ == '__main__':
    app.run(debug=True)

def add_user():
    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    """Créé un utilisateur"""
    new_user = input("Comment s'appelle ce nouvel utilisateur ?")
    cursor.execute('INSERT INTO users (name) VALUES (?)', (new_user,))
    conn.commit()
    print(f"Utilisateur ajouté : {new_user}")

    conn.close()

def list_users():
    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    """Affiche tous les utilisateurs."""
    cursor.execute('SELECT id, name FROM users')
    users = cursor.fetchall()
    print("\nListe des utilisateurs :")
    for user in users:
        print(f"ID: {user[0]}, Nom: {user[1]}")
    print()

    conn.close()

def add_task(description):
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    """Ajoute une tâche à la liste."""
    user = input("Insérer l'id de l'utilisateur à qui appartient cette tâche")
    cursor.execute('INSERT INTO tasks (description, id_user) VALUES (?,?)', (description,user,))
    conn.commit()
    print(f"Tâche ajoutée : {description} à l'utilisateur n°{user}")

    conn.close()

def list_tasks():
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    """Affiche toutes les tâches."""
    cursor.execute('SELECT id, description, status, completion, id_user FROM tasks')
    tasks = cursor.fetchall()
    print("\nListe des tâches :")
    for task in tasks:
        print(f"ID: {task[0]}, Description: {task[1]}, Complétion: {task[3]}%, Statut: {task[2]}, User n°{task[4]}")
    print()

    conn.close()

def mark_task_completed(task_id):
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    """Marque une tâche comme terminée."""
    cursor.execute('UPDATE tasks SET status = ? WHERE id = ?', ('Completed', task_id))
    conn.commit()
    print(f"Tâche ID {task_id} marquée comme terminée.")

    conn.close()

def update_completion(task_id):
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    """Actualise le % de complétion d'une tâche."""
    pourcentage = input("A quel pourcentage la tâche est-elle finie ?")
    cursor.execute('UPDATE tasks SET completion = ? WHERE id = ?', (pourcentage, task_id))
    conn.commit()
    print(f"Tâche ID {task_id} marquée comme étant {pourcentage}% terminée.")

    conn.close()

def delete_task(task_id):
    conn = sqlite3.connect('todo.db')
    cursor = conn.cursor()
    """Supprime une tâche de la liste."""
    cursor.execute('DELETE FROM tasks WHERE id = ?', (task_id,))
    conn.commit()
    print(f"Tâche ID {task_id} supprimée.")

    conn.close()

def main():
    """Boucle principale pour le gestionnaire de tâches."""
    while True:
        print("\n--- Gestionnaire de tâches ---")
        print("1. Ajouter un utilisateur")
        print("2. Afficher les utilisateurs")
        print("3. Ajouter une tâche")
        print("4. Afficher les tâches")
        print("5. Mettre à jour le degré de complétion d'une tâche")
        print("6. Marquer une tâche comme terminée")
        print("7. Supprimer une tâche")
        print("8. Quitter")
        choice = input("Choisissez une option : ")

        if choice == '1' : 
            add_user()
        elif choice == '2' :
            list_users()
        elif choice == '3':
            description = input("Entrez la description de la tâche : ")
            add_task(description)
        elif choice == '4':
            list_tasks()
        elif choice == '5':
            task_id = int(input("Entrez l'ID de la tâche à mettre à jour : "))
            update_completion(task_id)        
        elif choice == '6':
            task_id = int(input("Entrez l'ID de la tâche à marquer comme terminée : "))
            mark_task_completed(task_id)
        elif choice == '7':
            task_id = int(input("Entrez l'ID de la tâche à supprimer : "))
            delete_task(task_id)
        elif choice == '8':
            print("Au revoir!")
            break
        else:
            print("Option invalide.")
            break

if __name__ == "__main__":
    main()