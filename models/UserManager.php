<?php

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
}
