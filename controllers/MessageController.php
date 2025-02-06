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

    public function sendMessage(): void
    {
        try {
            // Récupère la conversation et l'utilisateur
            $userId = $_SESSION["user_id"];
            $conversationId = Utils::request("conversationId", -1);

            if ($conversationId === -1) {
                throw new ValidationException("Il n'y a pas de conversationId pour ce message !");
            }

            // Récupère les données du post
            $receiverId = Utils::request("receiverId");
            $message = Utils::request("message");

            // Sanitiser les données
            $message = FILTER_VAR($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($message)) {
                throw new ValidationException(("Le message ne dois pas être vide"));
            }

            // Décoder
            $messageDecoded = html_entity_decode($message, ENT_QUOTES, "UTF-8");

            // Enregistrer dans la bdd
            $messageManager = new MessageManager();
            $messageManager->sendMessage($userId, $conversationId, $messageDecoded);

            // Redirection
            Utils::redirect("message");
        } catch (ValidationException) {
            Utils::redirect("message");
        }
    }
}
