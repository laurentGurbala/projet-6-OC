<?php

/**
 * Classe contrôleur pour gérer les messages des utilisateurs.
 */
class MessageController
{

    public function showMessaging(): void
    {
        $userId = $_SESSION["user_id"];

        $messageManager = new MessageManager();
        $userManager = new UserManager();

        // Récupérer les messages
        $messages = $messageManager->getAllMessagesByUser($userId);

        // Extraire les ids des contacts
        $contactsIds = $messageManager->getUserContacts($userId, $messages);


        // Récupère les users correspondants
        $contacts = $userManager->getUsersByIds($contactsIds);

        // Id de la conversation
        $conversationId = Utils::request("conversationId", $contacts[0]->getId());

        // Récupère les derniers messages
        $lastMessages = $messageManager->getLastMessagesByUser($userId, $contacts, $messages);

        // Récupère les messages de la conversation active
        $conversationMessages = $messageManager->getMessagesByConversation($userId, $conversationId);

        $currentContact = $userManager->getUserById($conversationId);

        // Crée la vue des messages
        $view = new View("Messagerie");
        $view->render("messaging", [
            "messages" => $messages,
            "contacts" => $contacts,
            "lastMessages" => $lastMessages,
            "conversationId" => $conversationId,
            "conversationMessages" => $conversationMessages,
            "currentContact" => $currentContact
        ]);
    }
}
