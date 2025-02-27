# Projet To-Do List

## Le but du projet
Ce projet a pour objectif de créer une application web simple de gestion de notes (To-Do List) en utilisant PHP et MySQL. Il permet aux utilisateurs de s'inscrire, de se connecter, d'ajouter, de supprimer et de visualiser leurs notes et tâches à faire.

# Structure du projet :

- `img` : Contient les images du projet.
- `php` : Contient les fichiers PHP du projet.
- `css` : Contient les fichiers CSS du projet.
- `js` : Contient les fichiers JavaScript du projet.

# Explication des sessions PHP
Les sessions PHP sont utilisées pour gérer l'authentification des utilisateurs. Lorsqu'un utilisateur se connecte, ses informations sont stockées dans une session. Exemple avec le démarrage d'une session pour vérifier si l'utilisateur est connecté dans `header.php` :

```php
<?php
session_start();
$_SESSION['nom'] = "John";

echo "Bonjour " . $_SESSION['nom'];
?>
```

Dans l'exemple ci-dessus, on démarre une session avec `session_start()`, ce qui est nécessaire et obligatoire pour commencer la session de l'utilsateur, puis on stocke le nom de l'utilisateur dans la session avec `$_SESSION['nom'] = "John";`. Enfin, on affiche le nom de l'utilisateur avec `echo "Bonjour " . $_SESSION['nom'];`. Chaque fichier avec une session lancé "session_start()" pourra donc faire appel à `$_SESSION['nom'];` pour afficher le nom de l'utilisateur.

Autre exemple fréquemment utilisé :

```php
<?php
session_start(); // Lance la session
if (!isset($_SESSION['user'])) { // Vérifie si l'utilisateur est connecté
    header('Location: login.php'); // Redirige vers la page de connexion
    exit(); // Arrête l'exécution du script
}
?>
```

Donc là, ça permet de lancer la session (`session_start()`), puis de vérifier si l'utilisateur est connecté (`if (!isset($_SESSION['user'])`). Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion (`header('Location: login.php')`).

## Connexion SQL
La connexion à la base de données MySQL est gérée dans le fichier [`php/db.php`](db.php). Voici un extrait du code de connexion :

```php
<?php
$host = 'localhost'; // Lorsque la base de donnée est sur notre ordinateur, comme avec xamp, alors utiliser 'localhost'.
$username = 'root'; // Mot de passe par défaut, qui signifie la racine (root) de la base de donnée. Ca peut être remplacé par le nom d'utilisateur du compte de la base de donnée.
$password = ''; // Le mot de passe du compte, en l'occurence aucun avec xamp, donc on laisse vide.
$dbname = 'todolist'; // Le nom de la base de donnée. Ici, c'est 'todolist'.

try {
    $db = new mysqli($host, $username, $password, $dbname);
    if ($db->connect_error) {
        throw new Exception('Connection failed: ' . $db->connect_error);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
?>
```

Ce code permet donc de connecter la base de donnée en renseignant les infos de connexion : hôte (`$host`), nom d'utilisateur (`$username`), mot de passe (`$password`) et nom de la base de données (`$dbname`) qui par défaut est 'test' en utilisant xamp.

Pour visualiser la base de donnée, plusieurs méthodes existent, comme [l'extension VSCode DataBase Client JDBC](https://marketplace.visualstudio.com/items?itemName=cweijan.dbclient-jdbc) vous devrez aussi installer [l'extension pour MySQL, Data Base Client](https://marketplace.visualstudio.com/items?itemName=cweijan.vscode-database-client2).

Elle permet non seulement de visualiser, mais aussi modifer, ajouter, supprimer des données de la base de donnée. Elle permet donc d'exécuter des commandes SQL directement depuis VSCode.

Il faut penser à ouvrir Xamp en administrateur pour que la base de donnée soit accessible et lancer "MySQL".

Pour en apprendre plus, le site [W3Schools](https://www.w3schools.com/php/php_mysql_intro.asp) est une bonne documentation pour apprendre le SQL avec php.


# Requêtes POST
Les requêtes POST sont utilisées pour envoyer des données au serveur, par exemple lors de l'ajout ou de la suppression de tâches. Voici un exemple de traitement d'une requête POST dans `add_task.php` :

```php
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        include 'db.php';
        $userId = $_SESSION['user']['id'];
        addTask($_POST['task'], $userId);
    }
}

header('Location: index.php');
exit();
?>
```

Dans cet exemple, on vérifie si la méthode de la requête est POST (La méthode est définie dans les balies `form` en html avec la method `POST` et `action` doit contenie le lien de la requête. (`if ($_SERVER['REQUEST_METHOD'] === 'POST')`). Ensuite, on vérifie si le champ de la tâche est défini et qu'il n'est pas vide (`if (isset($_POST['task']) && !empty($_POST['task']))`). Si c'est le cas, on ajoute la tâche en appelant la fonction `addTask()`.