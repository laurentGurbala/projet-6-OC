<?php

// On démarre la session
session_start();

require_once "config/_config.php";
require_once "config/autoload.php";

$action = Utils::request("action", "home");

$messageController = new MessageController();
$_SESSION["nbMessages"] = $messageController->nbNewMessages();

// Try catch global pour gérer les erreurs
try {
    switch ($action) {
        case "home":
            // Affiche la page home
            $homeController = new HomeController();
            $homeController->showHome();
            break;

        case "listBooks":
            // Affiche la page des livres à échanger
            $homeController = new HomeController();
            $homeController->showListBooks();
            break;

        case "single":
            // Affiche la single page d'un livre
            $homeController = new HomeController();
            $homeController->showSinglePage();
            break;

        case "publicAccount":
            // Affiche la page du compte public
            $homeController = new HomeController();
            $homeController->showPublicAccount();
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
            $accountController = new AccountController();
            $accountController->showAccount();
            break;

        case "updateAccount":
            // Gère la modification de l'utilisateur
            Utils::checkIfUserIsConnected();
            $accountController = new AccountController();
            $accountController->updateAccount();
            break;

        case "uploadProfileImage":
            Utils::checkIfUserIsConnected();
            // Gère la modification de l'image de profil de l'utilisateur
            $accountController = new AccountController();
            $accountController->uploadProfileImage();
            break;

        case "uploadBookImage":
            Utils::checkIfUserIsConnected();
            // Gère la modification de l'image d'un livre
            $bookController = new BookController();
            $bookController->uploadBookImage();
            break;

        case "addBook":
            Utils::checkIfUserIsConnected();
            // Affiche la page de création d'un livre
            $bookController = new BookController();
            $bookController->showAddBookForm();
            break;

        case "createBook":
            utils::checkIfUserIsConnected();
            // Gère la création d'un livre
            $bookController = new BookController();
            $bookController->createBook();
            break;

        case "editBook":
            Utils::checkIfUserIsConnected();
            // Affiche la page d'édition d'un livre
            $bookController = new BookController();
            $bookController->showUpdateBookForm();
            break;

        case "updateBook":
            Utils::checkIfUserIsConnected();
            // Gère la modification d'un livre
            $bookController = new BookController();
            $bookController->updateBook();
            break;

        case "deleteBook":
            Utils::checkIfUserIsConnected();
            // Gère la suppression d'un livre
            $bookController = new BookController();
            $bookController->deleteBook();
            break;

        case "message":
            Utils::checkIfUserIsConnected();
            // Affiche la page de message
            $messageController->showMessaging();
            break;

        case "sendMessage":
            Utils::checkIfUserIsConnected();
            // Traite l'envoi du message
            $messageController->sendMessage();
            break;

        default:
            // Erreur 404
            $view = new View("erreur 404");
            $view->render("erreur");
            break;
    }
} catch (ValidationException $e) {
    // Erreurs de validation utilisateur
    echo "<div class='error-message'>Erreur de validation : " . htmlspecialchars($e->getMessage()) . "</div>";
} catch (Exception $e) {
    // Gestion des autres erreurs génériques
    echo "<div class='error-message'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
}
