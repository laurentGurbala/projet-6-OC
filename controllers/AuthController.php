<?php

/**
 * Classe AuthController
 *
 * Gère les actions liées à l'authentification, telles que l'inscription
 * et la connexion des utilisateurs.
 */
class AuthController
{
    /**
     * Affiche la vue d'inscription.
     *
     * @return void
     */
    public function showRegistration(): void
    {
        $view = new View("Inscription");
        $view->render("register");
    }

    public function showConnection(): void
    {
        $view = new View("Connexion");
        $view->render("connection");
    }

    public function registerUser(): void
    {
        try {
            // Récupération des données POST
            $login = Utils::request("login");
            $email = Utils::request("email");
            $password = Utils::request("password");

            $userManager = new UserManager();

            // Vérification des champs
            if (empty($login) || empty($email) || empty($password)) {
                throw new ValidationException("Tous les champs sont obligatoires.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("L'adresse email est invalide.");
            }

            // Vérification si  l'email existe déjà
            if ($userManager->isEmailExist($email)) {
                throw new ValidationException("L'email est déjà utilisé.");
            }

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Création d'une instance user
            $user = new User();
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);

            // Enregistrement du user
            $userManager->register($user);

            // Redirection
            Utils::redirect("connection");
        } catch (ValidationException $e) {
            // Gestion spécifique pour les erreurs de validation
            $view = new View("Inscription");
            $view->render("register", ["error" => $e->getMessage()]);
        }
    }
}
