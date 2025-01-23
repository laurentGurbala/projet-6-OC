<?php

class Book extends AbstractEntity
{
    private string $title;
    private string $author;
    private string $description;
    private bool $availability;
    private string $photo;
    private int $userId;

    // Getters
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function isAvailable(): bool
    {
        return $this->availability;
    }
    public function getPhoto(): string
    {
        return $this->photo;
    }
    public function getUserId(): string
    {
        return $this->userId;
    }

    // Setters
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAvailability(bool $availability)
    {
        $this->availability = $availability;
    }

    public function setPhoto(string $photo)
    {
        $this->photo = $photo;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }
}
