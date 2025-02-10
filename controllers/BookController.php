<?php

/**
 * Classe contrôleur pour gérer les actions liées au livre.
 */

class BookController
{

    public function showAddBookForm(): void
    {
        // Affiche le formulaire
        $view = new View("ajout d'un livre");
        $view->render("addBookForm");
    }

    /**
     * Affiche le formulaire de mise à jour d'un livre.
     *
     * @return void
     * @throws Exception Si le livre n'existe pas.
     */
    public function showUpdateBookForm(): void
    {
        // Récupération de l'id
        $id = Utils::request("id", -1);

        // Redirection au cas où l'id n'est pas présent
        if ($id < 1) {
            Utils::redirect("home");
        }

        // Récupération du livre
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            throw new Exception("Un problème est survenue.");
        }

        // Affiche la page de modification d'un livre
        $view = new View("Edition d'un livre");
        $view->render("updateBookForm", ["book" => $book]);
    }

    public function createBook(): void
    {
        $userId = $_SESSION["user_id"];

        // Récupère les données du POST
        $title = Utils::request("title");
        $author = Utils::request("author");
        $description = Utils::request("description");
        $availability = Utils::request("availability");
        $imageBase64 = Utils::request("profileImageBase64");

        // Vérification des champs obligatoires
        if (empty($title) || empty($author) || !isset($availability)) {
            throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
        }

        // Nettoyage des entrées
        $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author = filter_var($author, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $availability = filter_var($availability, FILTER_SANITIZE_NUMBER_INT);

        // Création d'un nouveau livre
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setAvailability($availability);
        $book->setUserId($userId);

        // Gestion de l'image si fournie
        if (!empty($imageBase64)) {
            try {
                $filePath = $this->saveBase64Image($imageBase64);
                $book->setPhoto($filePath);
            } catch (Exception $e) {
                throw new ValidationException("Erreur lors du traitement de l'image : " . $e->getMessage());
            }
        }

        // Sauvegarde en base
        $bookManager = new BookManager();
        $bookManager->addBook($book);

        // Redirection après création
        Utils::redirect("account");
    }

    private function saveBase64Image(string $base64): string
    {
        $uploadDir = PROJECT_ROOT . "/uploads/books/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Extraction des données de l'image
        list($meta, $data) = explode(',', $base64);
        preg_match('/data:image\/(\w+);base64/', $meta, $matches);
        $extension = $matches[1] ?? 'png';

        // Création d'un nom unique
        $fileName = uniqid("books_", true) . "." . $extension;
        $filePath = $uploadDir . $fileName;

        // Décodage et sauvegarde
        file_put_contents($filePath, base64_decode($data));

        return "./uploads/books/" . $fileName;
    }


    /**
     * Met à jour les informations d'un livre.
     *
     * @return void
     * @throws ValidationException Si les champs requis sont manquants ou invalides.
     */
    public function updateBook(): void
    {
        // Récupère le livre à modifier
        $bookId = Utils::request("bookId", -1);
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        // Récupère l'ancienne image du livre
        $oldImage = $book->getPhoto();

        // Récupère les données du POST
        $title = Utils::request("title");
        $author = Utils::request("author");
        $description = Utils::request("description");
        $availability = Utils::request("availability");
        $imageBase64 = Utils::request("profileImageBase64");

        // Sanitiser les données
        $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author = filter_var($author, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $availability = filter_var($availability, FILTER_SANITIZE_NUMBER_INT);

        if (empty($title) || empty($author) || !isset($availability)) {
            throw new ValidationException("Tous les champs sont obligatoires.");
        }

        // Gestion de l'image si fournie
        if (!empty($imageBase64)) {

            try {
                // Supprime l'ancienne image si elle existe
                if (!empty($oldImage) && file_exists(PROJECT_ROOT . "/" . $oldImage)) {
                    unlink(PROJECT_ROOT . "/" . $oldImage);
                }

                // Sauvegarde la nouvelle image
                $filePath = $this->saveBase64Image($imageBase64);
                $book->setPhoto($filePath);
            } catch (Exception $e) {
                throw new ValidationException("Erreur lors du traitement de l'image : " . $e->getMessage());
            }
        }

        /// Décodage des paramètres pour l'affichage
        $title_decoded = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
        $author_decoded = html_entity_decode($author, ENT_QUOTES, 'UTF-8');
        $description_decoded = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
        $availability_decoded = html_entity_decode($availability, ENT_QUOTES, 'UTF-8');

        // Mise à jour du livre avec les valeurs décodées
        $book->setTitle($title_decoded);
        $book->setAuthor($author_decoded);
        $book->setDescription($description_decoded);
        $book->setAvailability($availability_decoded);


        // Enregistre dans la BDD
        $bookManager->updateBook($book);

        // Redirection
        Utils::redirect("account");
    }

    /**
     * Supprime un livre.
     *
     * @return void
     */
    public function deleteBook(): void
    {
        $id = Utils::request("id", -1);

        // Supprimer le livre
        $bookManager = new BookManager();
        $bookManager->deleteBook($id);

        // Rediriger l'utilisateur vers son compte
        Utils::redirect("account");
    }

    /**
     * Gère l'upload d'une image pour un livre.
     *
     * @return void
     */
    public function uploadBookImage(): void
    {
        // Indique que la réponser sera en JSON
        header("Content-Type: appliation/json");

        try {
            // récuperer le book à éditer
            $bookId = Utils::request("id", -1);
            $bookManager = new BookManager();
            $book = $bookManager->getBookById($bookId);

            // Vérifie si le fichier a bien été uploadé
            $file = $this->validateFileUpload();

            // supprime l'ancienne image si nécessaire
            $currentImage = $book->getPhoto();
            if (!empty($currentImage) && file_exists($currentImage)) {
                unlink($currentImage);
            }

            // Déplace et enregistre le fichier
            $relativePath = $this->moveUploadedFile($file);

            // Enregistre le chemin de l'image dans la BDD
            $this->saveBookImage($book, $relativePath);

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
     * Valide le fichier uploadé.
     *
     * @return array Les données du fichier validé.
     * @throws FileException Si le fichier est invalide.
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
     * Déplace le fichier uploadé vers le répertoire cible.
     *
     * @param array $file Données du fichier.
     * @return string Chemin relatif vers le fichier enregistré.
     * @throws FileException Si le déplacement échoue.
     */
    private function moveUploadedFile(array $file): string
    {
        // Définit un chemin de destination pour le fichier
        $uploadDir = PROJECT_ROOT . "/uploads/books/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $uniqueFileName = uniqid("books_", true) . "." . $fileExtension;
        $destinationPath = $uploadDir . $uniqueFileName;

        // Erreur lors du déplacement du fichier
        if (!move_uploaded_file($fileTmpPath, $destinationPath)) {
            throw new FileException("Erreur lors de l'enregistrement du fichier");
        }

        return "./uploads/books/" . $uniqueFileName;
    }

    /**
     * Enregistre l'image d'un livre en base de données.
     *
     * @param Book $book Le livre concerné.
     * @param string $path Chemin de l'image.
     * @return void
     */
    private function saveBookImage(Book $book, string $path): void
    {
        $book->setPhoto($path);
        $bookManager = new BookManager();
        $bookManager->updateBook($book);
    }
}
