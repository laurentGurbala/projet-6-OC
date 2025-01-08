<?php

/**
 * Classe abstraite représentant un gestionnaire d'entités.
 *
 * Cette classe fournit une base commune pour les gestionnaires d'entités (managers),
 * en récupérant automatiquement l'instance du gestionnaire de base de données (`DBManager`).
 */
abstract class AbstractEntityManager
{
    /**
     * @var object $db Instance du gestionnaire de base de données.
     */
    protected $db;

    /**
     * Constructeur de la classe.
     *
     * Lors de l'instanciation, le constructeur récupère l'instance unique
     * de `DBManager` via son singleton. Cela permet à toutes les classes dérivées
     * d'accéder facilement à la base de données.
     */
    public function __construct()
    {
        // Récupération de l'instance unique de DBManager
        $this->db = DBManager::getInstance();
    }
}
