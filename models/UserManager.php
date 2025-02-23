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

        return $result ? $this->mapToUser($result) : null;
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données.
     *
     * @param int $userId L'ID de l'utilisateur à mettre à jour.
     * @param User $user L'instance de l'entité User contenant les nouvelles informations.
     * @return void
     */
    public function updateUser(int $userId, User $user): void
    {
        $sql = "UPDATE user SET email = :email, login = :login, password = :password, profile_image = :profileImage
        WHERE id = :id";
        $params =  [
            ":login" => $user->getLogin(),
            ":email" => $user->getEmail(),
            ":password" => $user->getPassword(),
            ":profileImage" => $user->getProfileImage(),
            ":id" => $user->getId()
        ];

        // Execute la requête
        $this->db->query($sql, $params);
    }

    /**
     * Récupère un utilisateur par son ID.
     *
     * @param int $userId L'ID de l'utilisateur à récupérer.
     * @return User|null L'utilisateur correspondant ou null si aucun utilisateur n'est trouvé.
     */
    public function getUserById(int $userId): ?User
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $query = $this->db->query($sql, ["id" => $userId]);
        $result = $query->fetch();

        return $result ? $this->mapToUser($result) : null;
    }

    /**
     * Récupère une liste d'utilisateurs à partir d'un tableau d'IDs.
     *
     * @param array $userIds Tableau contenant les IDs des utilisateurs à récupérer.
     * @return array Liste des objets User correspondant aux IDs fournis.
     */
    public function getUsersByIds(array $userIds): array
    {
        $users = [];
        foreach ($userIds as $userId) {
            $users[] = $this->getUserById($userId);
        }
        return $users;
    }

    /**
     * Convertit un tableau de données en objet User.
     *
     * @param array $data Tableau associatif contenant les données de l'utilisateur.
     * @return User Objet User correspondant aux données fournies.
     */
    private function mapToUser(array $data): User
    {
        $user = new User();
        $user->setId($data["id"]);
        $user->setLogin($data["login"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["password"]);
        $user->setCreatedAt(new DateTime($data["created_at"]));
        $user->setProfileImage($data["profile_image"]);

        return $user;
    }
}
