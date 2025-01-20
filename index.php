<?php

require_once "config/_config.php";
require_once "config/autoload.php";

$action = Utils::request("action", "home");

// Try catch global pour gérer les erreurs
try {
    switch ($action) {
        case "home":
            // Affiche la page home
            $homeController = new HomeController();
            $homeController->showHome();
            break;

        case "register":
            // Affiche la vue d'inscription
            $authController = new AuthController();
            $authController->showRegistration();
            break;

        case "registerUser":
            // Gère l'inscription d'un nouvel utilisateur
            $authController = new AuthController();
            $authController->registerUser();
            break;

        case "connection":
            // Affiche la vue de connexion
            $authController = new AuthController();
            $authController->showConnection();
            break;

        case "loginUser":
            // Gère la connexion d'un utilisateur
            $authController = new AuthController();
            $authController->loginUser();
            break;

        case "account":
            // Affiche la page mon compte d'un utilisateur
            Utils::checkIfUserIsConnected();
            $view = new View("compte");
            $view->render("account");
            break;
        default:
            // Gère les actions non définies
            throw new Exception("Page non trouvée.");
            break;
    }
} catch (ValidationException $e) {
    // Erreurs de validation utilisateur
    echo "<div class='error-message'>Erreur de validation : " . htmlspecialchars($e->getMessage()) . "</div>";
} catch (Exception $e) {
    // Gestion des autres erreurs génériques
    echo "<div class='error-message'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
}
