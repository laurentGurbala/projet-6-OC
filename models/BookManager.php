<?php

/**
 * Classe de gestion des livres.
 */
class BookManager extends AbstractEntityManager
{
    /**
     * Récupère les derniers livres ajoutés, triés par date de création.
     *
     * @param int $limit Nombre maximum de livres à récupérer (par défaut : 4).
     * @return Book[] Liste des livres.
     */
    public function getLastBooks(int $limit = 4): array
    {
        $sql = "SELECT  
        b.*, 
        u.login AS seller_pseudo 
        FROM book b
        JOIN user u ON b.user_id = u.id
        ORDER BY b.created_at DESC
        LIMIT $limit";

        $result = $this->db->query($sql);

        $books = [];

        while ($b = $result->fetch()) {
            $books[] = $this->mapToBook($b);
        }

        return $books;
    }

    public function getAllBooks(): array
    {
        $sql = "SELECT  
        b.*, 
        u.login AS seller_pseudo 
        FROM book b
        JOIN user u ON b.user_id = u.id
        ORDER BY b.created_at DESC";

        $result = $this->db->query($sql);

        $books = [];
        while ($b = $result->fetch()) {
            $books[] = $this->mapToBook($b);
        }

        return $books;
    }

    /**
     * Récupère tous les livres associés à un utilisateur spécifique.
     *
     * @param int $userId ID de l'utilisateur.
     * @return Book[] Liste des livres associés à l'utilisateur.
     */
    public function getBooksByUserId(int $userId): array
    {
        $sql = "SELECT * FROM book WHERE user_id = :user_id";
        $result = $this->db->query($sql, ["user_id" => $userId]);
        $books = [];

        while ($b = $result->fetch()) {
            $books[] = $this->mapToBook($b);
        }

        return $books;
    }

    /**
     * Compte le nombre de livres associés à un utilisateur.
     *
     * @param int $userId ID de l'utilisateur.
     * @return int Nombre de livres.
     */
    public function countBooksByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(*) as book_count FROM book WHERE user_id = :user_id";
        $result = $this->db->query($sql, ["user_id" => $userId]);
        $data = $result->fetch();

        return $data["book_count"] ?? 0;
    }

    /**
     * Récupère un livre par son ID.
     *
     * @param int $id ID du livre.
     * @return Book|null Le livre correspondant ou null si non trouvé.
     */
    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT * FROM book WHERE id = :id";
        $query = $this->db->query($sql, ["id" => $id]);
        $result = $query->fetch();

        return $result ? $this->mapToBook($result) : null;
    }

    /**
     * Met à jour les informations d'un livre existant.
     *
     * @param Book $book Instance du livre à mettre à jour.
     * @return void
     */
    public function updateBook(Book $book): void
    {
        $sql = "UPDATE book SET title = :title, author = :author, description = :description, availability = :availability, photo = :photo, user_id = :userId
        WHERE id = :id";
        $params = [
            ":title" => $book->getTitle(),
            ":author" => $book->getAuthor(),
            ":description" => $book->getDescription(),
            ":availability" => $book->isAvailable(),
            ":photo" => $book->getPhoto(),
            ":userId" => $book->getUserId(),
            ":id" => $book->getId()
        ];

        // Exécuter la requête
        $this->db->query($sql, $params);
    }

    /**
     * Supprime un livre par son ID.
     *
     * @param int $id ID du livre à supprimer.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $sql = "DELETE FROM book WHERE id = :id";
        $this->db->query($sql, ["id" => $id]);
    }

    /**
     * Mappe un tableau de données de la base à une instance de Book.
     *
     * @param array $data Données du livre issues de la base.
     * @return Book Instance de Book.
     */
    private function mapToBook(array $data): Book
    {
        $book = new Book();
        $book->setId($data["id"]);
        $book->setTitle($data["title"]);
        $book->setAuthor($data["author"]);
        $book->setDescription($data["description"]);
        $book->setAvailability((bool) $data["availability"]);
        $book->setPhoto($data["photo"]);
        $book->setUserId((int) $data["user_id"]);
        $book->setSellerPseudo($data["seller_pseudo"] ?? null);

        return $book;
    }
}
