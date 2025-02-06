<?php

class MessageManager extends AbstractEntityManager
{
    public function getAllMessagesByUser(int $userId): array
    {
        $sql = "SELECT * FROM message
        WHERE sender_id = :userId OR receiver_id = :userId
        ORDER BY sent_at DESC";

        $result = $this->db->query($sql, ["userId" => $userId, "userId" => $userId]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = $this->mapToMessage($message);
        }

        return $messages;
    }

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

    public function sendMessage(int $senderId, int $receiverId, string $content): void
    {
        $sql = "INSERT INTO message (sender_id, receiver_id, content, sent_at)
        VALUES (:sender_id, :receiver_id, :content, NOW())";

        $this->db->query($sql, [
            "sender_id" => $senderId,
            "receiver_id" => $receiverId,
            "content" => $content
        ]);
    }

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
