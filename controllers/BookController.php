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
}
