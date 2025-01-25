<?php

/**
 * Classe représentant un livre dans le système.
 */
class Book extends AbstractEntity
{
    /**
     * @var string Titre du livre.
     */
    private string $title;

    /**
     * @var string Auteur du livre.
     */
    private string $author;

    /**
     * @var string Description du livre.
     */
    private string $description;

    /**
     * @var bool Disponibilité du livre (true = disponible, false = indisponible).
     */
    private bool $availability;

    /**
     * @var string|null URL de la photo du livre (optionnelle).
     */
    private ?string $photo = null;

    /**
     * @var int ID de l'utilisateur associé au livre.
     */
    private int $userId;

    /**
     * @var string|null Pseudo du vendeur (optionnel).
     */
    private ?string $sellerPseudo;

    // Getters

    /**
     * Retourne le titre du livre.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Retourne l'auteur du livre.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Retourne la description du livre.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Vérifie si le livre est disponible.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->availability;
    }

    /**
     * Retourne l'URL de la photo du livre, si disponible.
     *
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * Retourne l'ID de l'utilisateur associé au livre.
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Retourne le pseudo du vendeur, si disponible.
     *
     * @return string|null
     */
    public function getSellerPseudo(): ?string
    {
        return $this->sellerPseudo;
    }

    // Setters

    /**
     * Définit le titre du livre.
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Définit l'auteur du livre.
     *
     * @param string $author
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Définit la description du livre.
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Définit la disponibilité du livre.
     *
     * @param bool $availability
     * @return void
     */
    public function setAvailability(bool $availability): void
    {
        $this->availability = $availability;
    }

    /**
     * Définit l'URL de la photo du livre (optionnel).
     *
     * @param string|null $photo
     * @return void
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * Définit l'ID de l'utilisateur associé au livre.
     *
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Définit le pseudo du vendeur (optionnel).
     *
     * @param string|null $sellerPseudo
     * @return void
     */
    public function setSellerPseudo(?string $sellerPseudo): void
    {
        $this->sellerPseudo = $sellerPseudo;
    }
}
