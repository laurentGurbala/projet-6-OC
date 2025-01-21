<?php

/**
 * Classe UserManager
 *
 * Gère les opérations relatives à l'entité `User`, telles que l'inscription,
 * la vérification d'existence d'un email, et la récupération d'un utilisateur
 * par son email.
 */
class UserManager extends AbstractEntityManager
{
    /**
     * Enregistre un utilisateur dans la base de données.
     * 
     * @param User $user Instance de l'entité User.
     * @return void
     */
    public function register(User $user): void
    {
        $sql = "INSERT INTO user (login, email, password)
        VALUES (:login, :email, :password)";
        $login =  $user->getLogin();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $this->db->query($sql, ["login" => $login, "email" => $email, "password" => $password]);
    }

    /**
     * Vérifie si un email existe déjà dans la base de données.
     * 
     * @param string $email L'adresse email à vérifier.
     * @return bool True si l'email existe, False sinon.
     */
    public function isEmailExist(string $email): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM user WHERE email = :email";
        $query = $this->db->query($sql, ["email" => $email]);
        $result = $query->fetch();
        return isset($result["count"]) && $result["count"] > 0;
    }

    /**
     * Récupère un utilisateur par son adresse email.
     * 
     * @param string $email L'adresse email de l'utilisateur.
     * @return User|null L'utilisateur correspondant ou null s'il n'existe pas.
     */
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM user where email = :email";
        $query = $this->db->query($sql, ["email" => $email]);
        $result = $query->fetch();

        // Si aucun utilisateur n'est trouvé
        if (!$result) {
            return null;
        }

        // Création d'une instance User
        $user = new User();
        $user->setId($result['id']);
        $user->setLogin($result['login']);
        $user->setEmail($result['email']);
        $user->setPassword($result['password']);

        return $user;
    }

    public function updateUser(int $userId, User $user): void
    {
        $sql = "UPDATE user SET email = :email, login = :login, password = :password 
        WHERE id = :id";
        $this->db->query($sql, [
            "login" => $user->getLogin(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "id" => $userId
        ]);
    }
}
