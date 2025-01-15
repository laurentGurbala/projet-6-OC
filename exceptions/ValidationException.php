<?php

/**
 * Classe ValidationException
 *
 * Représente une exception spécifique liée aux erreurs de validation utilisateur.
 */
class ValidationException extends Exception
{
    /**
     * Constructeur de la ValidationException.
     *
     * @param string $message Message d'erreur principal.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
