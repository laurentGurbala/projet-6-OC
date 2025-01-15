<?php

require_once "config/_config.php";
require_once "config/autoload.php";

$action = Utils::request("action", "home");

// Try catch global pour gérer les erreurs
try {
    switch ($action) {
        case "home":
            // Vérifie si l'utilisateur est connecté
            Utils::checkIfUserIsConnected();

            // Affiche la page home
            $homeController = new HomeController();
            $homeController->showHome();
            break;
        case "register":
            $authController = new AuthController();
            $authController->showRegistration();
            break;

        case "registerUser":
            $authController = new AuthController();
            $authController->registerUser();
            break;

        case "connection":
            $authController = new AuthController();
            $authController->showConnection();
            break;
        default:
            throw new Exception("Page non trouvée.");
            break;
    }
} catch (ValidationException $e) {
    // Erreurs de validation utilisateur
    echo "Erreur de validation : " . $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
