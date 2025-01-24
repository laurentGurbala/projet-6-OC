<?php

class BookManager extends AbstractEntityManager
{
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
            $book = new Book();
            $book->setId($b["id"]);
            $book->setTitle($b["title"]);
            $book->setAuthor($b["author"]);
            $book->setDescription($b["description"]);
            $book->setAvailability($b["availability"]);
            $book->setPhoto($b["photo"]);
            $book->setUserId($b["user_id"]);
            $book->setSellerPseudo($b["seller_pseudo"]);
            $books[] = $book;
        }

        return $books;
    }

    public function getBooksByUserId(int $userId): array
    {
        $sql = "SELECT * FROM book WHERE user_id = :user_id";
        $result = $this->db->query($sql, ["user_id" => $userId]);
        $books = [];

        while ($b = $result->fetch()) {
            $book = new Book();
            $book->setId($b["id"]);
            $book->setTitle($b["title"]);
            $book->setAuthor($b["author"]);
            $book->setDescription($b["description"]);
            $book->setAvailability($b["availability"]);
            $book->setPhoto($b["photo"]);
            $book->setUserId($b["user_id"]);
            $books[] = $book;
        }

        return $books;
    }

    public function countBooksByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(*) as book_count FROM book WHERE user_id = :user_id";
        $result = $this->db->query($sql, ["user_id" => $userId]);
        $data = $result->fetch();

        return $data["book_count"] ?? 0;
    }

    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT * FROM book WHERE id = :id";
        $query = $this->db->query($sql, ["id" => $id]);
        $result = $query->fetch();
        if ($result) {
            $book = new Book();
            $book->setId($result["id"]);
            $book->setTitle($result["title"]);
            $book->setAuthor($result["author"]);
            $book->setDescription($result["description"]);
            $book->setAvailability($result["availability"]);
            $book->setPhoto($result["photo"]);
            $book->setUserId($result["user_id"]);

            return $book;
        }

        return null;
    }

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

    public function deleteBook(int $id): void
    {
        $sql = "DELETE FROM book WHERE id = :id";
        $this->db->query($sql, ["id" => $id]);
    }
}
