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
}
