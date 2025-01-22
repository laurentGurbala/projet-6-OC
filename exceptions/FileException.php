<?php

/**
 * Classe FileException
 * 
 * Représente une exception spécifique liée aux erreurs de gestion de fichiers
 */
class FileException extends Exception
{
    /**
     * Constructeur de la FileException.
     *
     * @param string $message Message d'erreur principal.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
