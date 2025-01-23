<?php

/**
 * Classe contrôleur pour gérer les actions liées au compte utilisateur.
 */
class AccountController
{

    /**
     * Affiche la page du compte utilisateur avec ses données.
     */
    public function showAccount(): void
    {
        // Récupérer l'utilisateur
        $user = $this->getUser();

        // Récupérer les livres de l'utilisateur
        $userId = $_SESSION["user_id"];
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId($userId);

        $bookCount = $bookManager->countBooksByUserId($userId);

        // Affiche la vue avec les données utilisateur
        $view = new View("Mon compte");
        $view->render("account", ["user" => $user, "books" => $books, "bookCount" => $bookCount]);
    }

    /**
     * Met à jour les informations du compte utilisateur (email, login, mot de passe).
     */
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

            // Récupérer l'utilisateur
            $user = $this->getUser();

            // Mise à jour des données utilisateur
            $user->setLogin($login);
            $user->setEmail($email);

            // Mise à jour du mot de passe si fourni
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }

            $userManager = new UserManager();
            $userManager->updateUser($user->getId(), $user);

            // Redirection
            Utils::redirect("account");
        } catch (ValidationException $e) {
            // Gestion spécifique pour les erreurs de validation
            $view = new View("Mon compte");
            $view->render("account", ["error" => $e->getMessage()]);
        }
    }

    /**
     * Permet à l'utilisateur de télécharger et de mettre à jour son image de profil.
     * Répond avec un message JSON de succès ou d'erreur.
     */
    public function uploadProfileImage(): void
    {
        // Indique que la réponse sera en JSON
        header('Content-Type: application/json');

        try {
            // Récupérer l'utilisateur
            $user = $this->getUser();

            // Vérifie si le fichier a bien été uploadé
            $file = $this->validateFileUpload();

            // Supprime l'ancienne image si nécessaire
            $this->deleteOldProfileImage($user);

            // Déplace le fichier et enregistre-le
            $relativePath = $this->moveUploadedFile($file);

            // Enregistre le chemin de l'image dans la BDD
            $this->saveProfileImage($user, $relativePath);

            // Répond avec succès
            echo json_encode(["success" => true, "message" => "Fichier uploadé avec succès."]);
            return;
        } catch (FileException $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "error" => "Erreur inattendue : " . $e->getMessage()]);
        }
    }

    /**
     * Récupère l'utilisateur actuel basé sur l'ID de session.
     * 
     * @return User L'objet utilisateur récupéré.
     * @throws Exception Si l'utilisateur est introuvable.
     */
    private function getUser()
    {
        $userId = $_SESSION["user_id"];
        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        return $user;
    }

    /**
     * Valide le fichier téléchargé en vérifiant l'extension et la taille.
     * 
     * @return array Les informations du fichier si valide.
     * @throws FileException Si le fichier n'est pas valide.
     */
    private function validateFileUpload(): array
    {
        if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] === UPLOAD_ERR_OK) {
            $file = $_FILES["profileImage"];

            // Vérification de base
            $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
            $maxFileSize = 8 * 1024 * 1024; // 8 MO

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
                throw new FileException("Fichier trop volumineux (max 8 MB)");
            }

            return $file;
        } else {
            throw new FileException("Erreur lors de l'enregistrement du fichier");
        }
    }

    /**
     * Supprime l'ancienne image de profil si elle existe.
     * 
     * @param User $user L'objet utilisateur pour vérifier et supprimer l'ancienne image.
     */
    private function deleteOldProfileImage(User $user): void
    {
        $currentProfileImage = $user->getProfileImage();
        if (!empty($currentProfileImage) && file_exists($currentProfileImage)) {
            unlink($currentProfileImage);
            $user->setProfileImage(null);
        }
    }

    /**
     * Déplace le fichier téléchargé vers le répertoire approprié et génère un nom unique pour le fichier.
     * 
     * @param array $file Les informations du fichier téléchargé.
     * @return string Le chemin relatif du fichier déplacé.
     * @throws FileException Si une erreur survient lors du déplacement du fichier.
     */
    private function moveUploadedFile(array $file): string
    {
        // Définit un chemin de destination pour le fichier
        $uploadDir = PROJECT_ROOT . "/uploads/profiles/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $uniqueFileName = uniqid("profile_", true) . "." . $fileExtension;
        $destinationPath = $uploadDir . $uniqueFileName;

        // Erreur lors du déplacement du fichier
        if (!move_uploaded_file($fileTmpPath, $destinationPath)) {
            throw new FileException("Erreur lors de l'enregistrement du fichier");
        }

        return "./uploads/profiles/" . $uniqueFileName;
    }

    /**
     * Enregistre le chemin de l'image de profil dans la base de données.
     * 
     * @param User $user L'utilisateur dont l'image de profil doit être mise à jour.
     * @param string $path Le chemin relatif de l'image de profil.
     */
    private function saveProfileImage(User $user, string $path): void
    {
        $user->setProfileImage($path);
        $userManager = new UserManager();
        $userManager->updateUser($user->getId(), $user);
    }
}
