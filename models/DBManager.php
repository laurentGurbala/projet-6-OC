<?php

/**
 * Classe singleton pour gérer la connexion à la base de données.
 *
 * Cette classe fournit une instance unique de `DBManager` pour centraliser la gestion
 * des interactions avec la base de données via PDO.
 */
class DBManager
{

    /**
     * @var DBManager|null Instance unique de la classe (singleton).
     */
    private static $instance;

    /**
     * @var PDO Instance de PDO pour la connexion à la base de données.
     */
    private $db;

    /**
     * Constructeur privé pour empêcher l'instanciation directe.
     * Initialise la connexion à la base de données via PDO.
     */
    private function __construct()
    {
        // Initialisation de la connexion PDO
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        // Configuration des attributs PDO
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Retourne l'instance unique de `DBManager`.
     *
     * Si aucune instance n'existe, elle est créée.
     *
     * @return DBManager Instance unique de la classe.
     */
    public static function getInstance(): DBManager
    {
        if (!self::$instance) {
            self::$instance = new DBManager();
        }

        return self::$instance;
    }

    /**
     * Retourne l'instance PDO pour exécuter des requêtes directement.
     *
     * @return PDO L'instance PDO utilisée pour la connexion à la base de données.
     */
    public function getPDO(): PDO
    {
        return $this->db;
    }

    /**
     * Exécute une requête SQL avec ou sans paramètres et retourne un `PDOStatement`.
     *
     * - Si aucun paramètre n'est fourni, la méthode utilise `PDO::query`.
     * - Si des paramètres sont fournis, elle utilise `PDO::prepare` et `PDOStatement::execute`.
     *
     * @param string $sql La requête SQL à exécuter.
     * @param array|null $params (optionnel) Tableau de paramètres pour une requête préparée.
     * @return PDOStatement Le résultat de la requête sous forme de `PDOStatement`.
     */
    public function query(string $sql, ?array $params = null): PDOStatement
    {
        if ($params == null) {
            // Requête simple
            $query = $this->db->query($sql);
        } else {
            // Requête préparée avec paramètres
            $query = $this->db->prepare($sql);
            $query->execute($params);
        }

        return $query;
    }
}
