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

    public function uploadProfileImage(): void
    {
        try {
            // Vérifie si le fichier a bien été uploadé
            if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] === UPLOAD_ERR_OK) {
                $file = $_FILES["profileImage"];

                // Vérification de base
                $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                $maxFileSize = 2 * 1024 * 1024; // 2 MB


                $fileTmpPath = $file['tmp_name'];
                $fileName = $file["name"];
                $fileSize = $file["size"];

                // Sanitase le nom du fichier
                $safeFileName = preg_replace('/[^a-zA-Z0-9\._-]/', '', $fileName);

                // Récupère l'extenstion du fichier
                $fileExtension = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));

                // Vérifie l'extension
                if (!in_array($fileExtension, $allowedExtensions)) {
                    throw new FileException("Extension non autorisée: $safeFileName.$fileExtension (autorisé: jpg, jpeg, png, gif)");
                }

                // Vérifie la taille du fichier
                if ($fileSize > $maxFileSize) {
                    throw new FileException("Fichier trop volumineux (max 2 MB)");
                }

                // Définit un chemin de destination pour le fichier
                $uploadDir = PROJECT_ROOT . "/uploads/profiles/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $uniqueFileName = uniqid("profile_", true) . "." . $fileExtension;
                $destinationPath = $uploadDir . $uniqueFileName;

                // Déplace le fichier vers le dossier final
                if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                    // Todo save in the db
                    echo "chargement réussi !";
                } else {
                    throw new FileException("Erreur lors de l'enregistrement du fichier");
                }
            } else {
                throw new FileException("Erreur lors de l'enregistrement du fichier");
            }
        } catch (FileException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur inattendue : " . $e->getMessage();
        }
    }
}
