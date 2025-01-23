<?php

class BookManager extends AbstractEntityManager
{

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
}
