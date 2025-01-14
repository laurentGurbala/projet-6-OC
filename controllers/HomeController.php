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
        $view = new View("Accueil");
        $view->render("home");
    }
}
