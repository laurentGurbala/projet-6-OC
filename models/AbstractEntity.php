<?php

/**
 * Classe abstraite représentant une entité de base avec un mécanisme d'hydratation.
 * 
 * Cette classe fournit des fonctionnalités génériques pour gérer les entités :
 * - Un identifiant unique (`id`).
 * - Une méthode d'hydratation automatique basée sur les setters des propriétés.
 */
class AbstractEntity
{

    /**
     * @var int $id Identifiant unique de l'entité (par défaut : -1 pour indiquer un ID non défini).
     */
    protected int $id = -1;

    /**
     * Constructeur permettant d'initialiser l'entité avec des données.
     *
     * @param array $data Tableau associatif contenant les données à hydrater dans l'entité.
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Méthode protégée pour hydrater l'entité.
     *
     * Cette méthode parcourt un tableau associatif (`$data`) et tente de
     * trouver un setter correspondant à chaque clé. Si un setter existe, il
     * est appelé avec la valeur associée.
     *
     * Exemple :
     * - Pour une clé `first_name`, elle cherche un setter `setFirstName`.
     *
     * @param array $data Tableau associatif contenant les données à hydrater.
     * @return void
     */
    protected function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /** 
     * Setter pour l'id.
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Getter pour l'id.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
