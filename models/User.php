<?php

/**
 * Classe représentant un utilisateur.
 *
 * Hérite de `AbstractEntity` pour bénéficier du mécanisme d'hydratation et de gestion des entités.
 * Cette classe contient les propriétés et méthodes spécifiques à un utilisateur, telles que le login,
 * l'email et le mot de passe.
 */
class User extends AbstractEntity
{
    /**
     * @var string $login Le nom d'utilisateur (login) de l'utilisateur.
     */
    private string $login;

    /**
     * @var string $email L'adresse email de l'utilisateur.
     */
    private string $email;

    /**
     * @var string $password Le mot de passe de l'utilisateur (hashé pour des raisons de sécurité).
     */
    private string $password;

    private DateTime $createdAt;

    /**
     * Définit le login de l'utilisateur.
     *
     * @param string $login Le nom d'utilisateur (login).
     * @return void
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * Retourne le login de l'utilisateur.
     *
     * @return string Le nom d'utilisateur (login).
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Définit l'adresse email de l'utilisateur.
     *
     * @param string $email L'adresse email.
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Retourne l'adresse email de l'utilisateur.
     *
     * @return string L'adresse email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     *
     * @param string $password Le mot de passe (en clair ou hashé selon le contexte).
     *                         Il est recommandé de toujours le stocker sous forme de hash sécurisé.
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Retourne le mot de passe de l'utilisateur.
     *
     * @return string Le mot de passe (probablement sous forme de hash).
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
