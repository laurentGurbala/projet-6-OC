<?php

class AuthController
{
    public function showRegistration(): void
    {
        $view = new View("Inscription");
        $view->render("register");
    }
}
