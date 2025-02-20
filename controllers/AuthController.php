<?php

/**
 * Classe AuthController
 *
 * Gère les actions liées à l'authentification, telles que
 * l'inscription, la connexion, et l'affichage des formulaires associés.
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

    /**
     * Affiche la vue de connexion.
     *
     * @return void
     */
    public function showConnection(): void
    {
        if (isset($_SESSION["user_id"])) {
            unset($_SESSION["user_id"]);
        }

        $view = new View("Connexion");
        $view->render("connection");
    }


    /**
     * Gère l'inscription d'un nouvel utilisateur.
     *
     * @return void
     * @throws ValidationException Si les données sont invalides ou si l'email est déjà utilisé.
     */
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

    /**
     * Gère la connexion d'un utilisateur existant.
     *
     * @return void
     * @throws ValidationException Si les identifiants sont incorrects.
     */
    public function loginUser(): void
    {
        try {
            $email = Utils::request("email");
            $password = Utils::request("password");

            $userManager = new UserManager();
            $user = $userManager->getUserByEmail($email);

            // Validation des identifiants
            if (!$user || !password_verify($password, $user->getPassword())) {
                throw new ValidationException("Email ou mot de passe incorrect.");
            }

            // Création la session utilisateur
            $_SESSION["user_id"] = $user->getId();

            // Redirection après connexion
            Utils::redirect("home");
        } catch (ValidationException $e) {
            // Rechargement de la page avec un message d'erreur
            $view = new View("Connexion");
            $view->render("connection", ["error" => $e->getMessage()]);
        }
    }
}
