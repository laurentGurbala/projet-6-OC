<?php

/**
 * Classe contrôleur pour gérer les messages des utilisateurs.
 */
class MessageController
{

    public function showMessaging(): void
    {
        $view = new View("Messagerie");
        $view->render("messaging");
    }
}
