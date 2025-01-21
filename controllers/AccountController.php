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
            if (empty($email) || empty($login)) {
                throw new ValidationException("Tous les champs sont obligatoires.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("L'adresse email est invalide.");
            }

            // Récupération de l'utilisateur actuel
            $userId = $_SESSION["user_id"];
            $userManager = new UserManager();
            $user = $userManager->getUserById($userId);

            if (!$user) {
                throw new Exception("Utilisateur introuvable.");
            }

            // Mise à jour des données utilisateur
            $user->setLogin($login);
            $user->setEmail($email);

            // Mise à jour du mot de passe si fourni
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }

            $userManager->updateUser($userId, $user);

            // Recharger les données utilisateur pour la vue
            $updatedUser = $userManager->getUserById($userId);

            // Redirection ou rechargement avec les données mises à jour
            $view = new View("Mon compte");
            $view->render("account", ["user" => $updatedUser]);
        } catch (ValidationException $e) {
            // Gestion spécifique pour les erreurs de validation
            $view = new View("Mon compte");
            $view->render("account", ["error" => $e->getMessage()]);
        }
    }
}
