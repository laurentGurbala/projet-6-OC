<?php

/**
 * Classe contrôleur pour gérer les actions liées au livre.
 */

class BookController
{
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

    public function updateBook(): void
    {
        // Récupère le livre à modifier
        $bookId = Utils::request("bookId", -1);
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        // Récupère les données du POST
        $title = Utils::request("title");
        $author = Utils::request("author");
        $description = Utils::request("description");
        $availability = Utils::request("availability");

        // Sanitiser les données
        $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author = filter_var($author, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $availability = filter_var($availability, FILTER_SANITIZE_NUMBER_INT);

        if (empty($title) || empty($author) || !isset($availability)) {
            throw new ValidationException("Tous les champs sont obligatoires.");
        }

        // Décodage de la description pour l'affichage
        $description_decoded = html_entity_decode($description, ENT_QUOTES, 'UTF-8');

        // Mise à jour du livre
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description_decoded);
        $book->setAvailability($availability);

        // Enregistre dans la BDD
        $bookManager->updateBook($book);

        // Redirection
        Utils::redirect("account");
    }

    public function deleteBook(): void
    {
        $id = Utils::request("id", -1);

        // Supprimer le livre
        $bookManager = new BookManager();
        $bookManager->deleteBook($id);

        // Rediriger l'utilisateur vers son compte
        Utils::redirect("account");
    }

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

    private function saveBookImage(Book $book, string $path): void
    {
        $book->setPhoto($path);
        $bookManager = new BookManager();
        $bookManager->updateBook($book);
    }
}
