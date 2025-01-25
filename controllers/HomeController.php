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
}
