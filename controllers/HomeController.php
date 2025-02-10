<?php

/**
 * Classe HomeController
 *
 * Gère les actions liées à la page d'accueil de l'application.
 */
class HomeController
{

    /**
     * Affiche la page d'accueil.
     *
     * @return void
     */
    public function showHome(): void
    {
        // Récupère les derniers ajouts de livre
        $bookManager = new BookManager();
        $lastBooks = $bookManager->getLastBooks();

        // Affiche la vue
        $view = new View("Accueil");
        $view->render("home", ["books" => $lastBooks]);
    }

    /**
     * Affiche la liste des livres avec option de recherche par titre.
     *
     * @return void
     */
    public function showListBooks(): void
    {
        // Récupération éventuelle du filtre
        $searchTerm = Utils::request("q", "");
        $bookManager = new BookManager();

        if (!empty($searchTerm)) {
            // Récupère les livres correspondants à une recherche
            $books = $bookManager->getSearchBooksByTitle($searchTerm);
        } else {
            // Récupérer l'ensemble des livres
            $books = $bookManager->getAllBooks();
        }

        // Afficher la vue
        $view = new View("Nos livres");
        $view->render("listBooks", ["books" => $books]);
    }

    /**
     * Affiche la page d'un livre spécifique avec ses détails et son propriétaire.
     *
     * @return void
     */
    public function showSinglePage(): void
    {
        $bookId = Utils::request("bookId", -1);

        // Récupère le livre
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        // Rècupère le propriétaire
        $userManager = new UserManager();
        $owner = $userManager->getUserById($book->getUserId());

        // Affichage sécurisé du titre du livre
        $view = new View("Livre " . htmlspecialchars($book->getTitle(), ENT_QUOTES, 'UTF-8'));
        $view->render("singlePage", ["book" => $book, "owner" => $owner]);
    }

    /**
     * Affiche le profil public d'un utilisateur avec ses livres.
     *
     * @return void
     */
    public function showPublicAccount(): void
    {
        $userId = Utils::request("userId", -1);

        // Récupère le propriètaire du compte
        $userManager = new UserManager();
        $owner = $userManager->getUserById($userId);

        // Récupère la liste de livre
        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId($userId);

        // Récupère le nombre de livres
        $bookCount = $bookManager->countBooksByUserId($userId);

        // Crée la vue
        $view = new View("Compte de " . htmlspecialchars($owner->getLogin(), ENT_QUOTES, 'UTF-8'));
        $view->render("publicAccount", ["owner" => $owner, "books" => $books, "bookCount" => $bookCount]);
    }
}
