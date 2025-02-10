# Installation du projet TomTroc

Ce guide explique comment installer et configurer l'application **TomTroc** en local.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- [PHP](https://www.php.net/) (version 8.0 ou ultérieure)
- [MySQL/MariaDB](https://mariadb.org/) (avec phpMyAdmin si nécessaire)
- [Apache](https://httpd.apache.org/) ou un serveur local comme [XAMPP](https://www.apachefriends.org/fr/index.html) ou [WampServer](https://www.wampserver.com/)

## Installation

### 1. Cloner le projet

```sh
# Via Git
git clone https://github.com/ton-utilisateur/tom-troc.git
cd tom-troc
```

Ou téléchargez et extrayez le projet manuellement.

### 2. Configuration de la base de données

1. Ouvrez **phpMyAdmin** ou utilisez MySQL en ligne de commande.
2. Créez une base de données :

```sql
CREATE DATABASE tom_troc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Importez le fichier SQL fourni :
   - Via **phpMyAdmin** : Allez dans "Importer" et sélectionnez `tom_troc.sql`.
   - Via **MySQL CLI** :

```sh
mysql -u root -p tom_troc < chemin/vers/tom_troc.sql
```

### 3. Configuration de l'application

Dans le dossier `config`, créez un fichier `_config.php` en vous basant sur `_config.example.php`. Ce fichier doit contenir les informations suivantes :

```php
<?php

// On démarre la session
session_start();

// Chemin vers la racine du projet
define("PROJECT_ROOT", dirname(__DIR__));

// Chemin vers les templates de vues.
define('TEMPLATE_VIEW_PATH', './views/templates/');
// Chemin vers le template principal.
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');


// Valeur relative à la BDD
define('DB_HOST', 'localhost');
define('DB_NAME', 'tom_troc');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
```

> **Remarque :** Remplacez `votre_utilisateur` et `votre_mot_de_passe` par vos informations locales.

### 4. Lancer le serveur local

Si vous utilisez PHP en local :

```sh
php -S localhost:8000 -t public
```

Si vous utilisez **Apache/XAMPP/Wamp**, placez le projet dans le dossier `htdocs` et accédez à `http://localhost/tom-troc/`.

## Utilisation

Une fois le serveur lancé, vous pouvez commencer à utiliser l'application en accédant à l'URL locale.

---

Si vous rencontrez des problèmes, vérifiez les logs d'erreur (`logs/` ou `error.log`) et assurez-vous que toutes les dépendances sont bien installées.
