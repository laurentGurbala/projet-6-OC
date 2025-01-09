<?php

/**
 * Classe AuthController
 *
 * Gère les actions liées à l'authentification, telles que l'inscription
 * et la connexion des utilisateurs.
 */
class AuthController
{
    /**
     * Affiche la vue d'inscription.
     *
     * @return void
     */
    public function showRegistration(): void
    {
        $view = new View("Inscription");
        $view->render("register");
    }
}
