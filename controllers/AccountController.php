<?php

class AccountController
{
    public function showAccount(): void
    {
        // Récupération de l'utilisateur connecté
        $userId = $_SESSION["user_id"];
        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        // Affiche la vue avec les données utilisateur
        $view = new View("Mon compte");
        $view->render("account", ["user" => $user]);
    }

    public function updateAccount(): void
    {
        try {
            // Récupération des données POST
            $email = Utils::request("email");
            $password = Utils::request("password");
            $login = Utils::request("login");

            // Validation des données
            if (empty($email) || empty($login) || empty($password)) {
                throw new ValidationException("Tous les champs sont obligatoires.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("L'adresse email est invalide.");
            }

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Création d'une instance user
            $user = new User();
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);

            // Mise à jour
            $userManager = new UserManager();
            $userId = $_SESSION["user_id"];
            $userManager->updateUser($userId, $user);

            Utils::redirect("account");
        } catch (ValidationException $e) {
            // Gestion spécifique pour les erreurs de validation
            $view = new View("Mon compte");
            $view->render("account", ["error" => $e->getMessage()]);
        }
    }
}
