<?php

class MessageManager extends AbstractEntityManager
{
    /**
     * Récupère tous les messages envoyés ou reçus par un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return array Liste des messages sous forme d'objets Message.
     */
    public function getAllMessagesByUser(int $userId): array
    {
        $sql = "SELECT * FROM message
        WHERE sender_id = :userId OR receiver_id = :userId
        ORDER BY sent_at DESC";

        $result = $this->db->query($sql, ["userId" => $userId]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = $this->mapToMessage($message);
        }

        return $messages;
    }

    /**
     * Récupère la liste des contacts avec qui un utilisateur a échangé des messages.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @param array $messages Liste des messages de l'utilisateur.
     * @return array Liste des IDs des contacts uniques.
     */
    public function getUserContacts(int $userId, array $messages): array
    {
        $contacts = [];

        foreach ($messages as $message) {

            $senderId = $message->getSenderId();
            $receiverId = $message->getReceiverId();

            if ($senderId !== $userId) {
                $contacts[] = $senderId;
            }

            if ($receiverId !== $userId) {
                $contacts[] = $receiverId;
            }
        }

        return array_unique($contacts);
    }

    /**
     * Récupère le dernier message échangé avec chaque contact.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @param array $contacts Liste des contacts de l'utilisateur.
     * @param array $messages Liste des messages de l'utilisateur.
     * @return array Tableau associatif [contactId => dernier message].
     */
    public function getLastMessagesByUser(int $userId, array $contacts, array $messages): array
    {
        $lastMessages = [];

        foreach ($contacts as $contact) {
            $contactId = $contact->getId();

            // Filtrer les messages entre l'utilisateur et ce contact
            $filteredMessages = array_filter($messages, function ($message) use ($userId, $contactId) {
                return ($message->getSenderId() == $userId && $message->getReceiverId() == $contactId) ||
                    ($message->getSenderId() == $contactId && $message->getReceiverId() == $userId);
            });

            // Trier les messages par date décroissante
            usort($filteredMessages, function ($a, $b) {
                return $b->getSentAt() <=> $a->getSentAt();
            });

            // Prendre le dernier message
            if (!empty($filteredMessages)) {
                $lastMessages[$contactId] = reset($filteredMessages);
            }
        }

        return $lastMessages;
    }

    /**
     * Récupère tous les messages échangés entre l'utilisateur et un contact spécifique.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @param int $contactId L'ID du contact.
     * @return array Liste des messages triés par ordre chronologique.
     */
    public function getMessagesByConversation(int $userId, int $contactId): array
    {
        $sql = "SELECT * FROM message
            WHERE (sender_id = :userId AND receiver_id = :contactId)
            OR (sender_id = :contactId AND receiver_id = :userId)
            ORDER BY sent_at ASC";


        $result = $this->db->query($sql, ["userId" => $userId, "contactId" => $contactId]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = $this->mapToMessage($message);
        }
        return $messages;
    }

    /**
     * Envoie un message d'un utilisateur à un autre.
     *
     * @param int $senderId L'ID de l'expéditeur.
     * @param int $receiverId L'ID du destinataire.
     * @param string $content Contenu du message.
     */
    public function save(int $senderId, int $receiverId, string $content): void
    {
        $sql = "INSERT INTO message (sender_id, receiver_id, content, sent_at)
        VALUES (:sender_id, :receiver_id, :content, NOW())";

        $this->db->query($sql, [
            "sender_id" => $senderId,
            "receiver_id" => $receiverId,
            "content" => $content
        ]);
    }

    /**
     * Convertit un tableau de données en objet Message.
     *
     * @param array $data Données du message issues de la base de données.
     * @return Message Instance de l'objet Message.
     */
    private function mapToMessage(array $data): Message
    {
        $message = new Message();
        $message->setId($data["id"]);
        $message->setSenderId($data["sender_id"]);
        $message->setReceiverId($data["receiver_id"]);
        $message->setContent($data["content"]);
        $message->setSentAt(new DateTime($data["sent_at"]));
        $message->setView($data["view"]);

        return $message;
    }
}
