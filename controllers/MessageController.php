<?php

/**
 * Classe contrôleur pour gérer les messages des utilisateurs.
 */
class MessageController
{

    /**
     * Affiche la messagerie de l'utilisateur connecté.
     * 
     * Cette méthode récupère les messages de l'utilisateur, identifie ses contacts, 
     * détermine la conversation active, charge les messages correspondants et 
     * affiche la vue de la messagerie.
     */
    public function showMessaging(): void
    {
        $userId = $_SESSION["user_id"];

        $messageManager = new MessageManager();
        $userManager = new UserManager();

        // Récupérer les messages et les contacts
        $messages = $messageManager->getAllMessagesByUser($userId);
        $contactsIds = $messageManager->getUserContacts($userId, $messages);

        // Déterminer l'ID de la conversation active
        $conversationId = $this->determineConversationId($contactsIds);

        // Charger les contacts et vérifier la conversation active
        $contacts = $userManager->getUsersByIds($contactsIds);
        $conversationId = $this->ensureValidConversationId($conversationId, $contacts);

        // Récupérer les derniers messages et ceux de la conversation active
        $lastMessages = $messageManager->getLastMessagesByUser($userId, $contacts, $messages);
        $conversationMessages = $messageManager->getMessagesByConversation($userId, $conversationId);
        $currentContact = $userManager->getUserById($conversationId);

        // Marquer les messages de cette conversation comme lus
        $messageManager->markMessageAsRead($userId, $conversationId);
        $_SESSION["nbMessages"] = $this->nbNewMessages();

        // Crée la vue des messages
        $view = new View("Messagerie");
        $view->render("messaging", [
            "contacts" => $contacts,
            "lastMessages" => $lastMessages,
            "conversationId" => $conversationId,
            "conversationMessages" => $conversationMessages,
            "currentContact" => $currentContact
        ]);
    }

    /**
     * Gère l'envoi d'un message et sa validation.
     */
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
            $messageManager->save($userId, $conversationId, $messageDecoded);

            // Redirection
            Utils::redirect("message");
        } catch (ValidationException) {
            Utils::redirect("message");
        }
    }

    public function nbNewMessages(): int
    {
        $nbMessage = 0;

        // Vérifier que l'utilisateur est connecté
        if (isset($_SESSION["user_id"])) {
            // Récupération du nombre de nouveaux messages
            $messageManager = new MessageManager();
            $nbMessage = $messageManager->countNewMessages($_SESSION["user_id"]);
        }

        return $nbMessage;
    }

    /**
     * Détermine l'ID de la conversation active en fonction des paramètres reçus.
     *
     * @param array $contactsIds Liste des contacts existants.
     * @return int L'ID de la conversation active ou -1 si non défini.
     */
    private function determineConversationId(array &$contactsIds): int
    {
        $conversationId = Utils::request("conversationId", -1);

        if ($conversationId > -1 && !in_array($conversationId, $contactsIds)) {
            $contactsIds[] = $conversationId;
        }

        return $conversationId;
    }

    /**
     * Vérifie et assigne un ID de conversation valide.
     *
     * @param int $conversationId L'ID de la conversation potentielle.
     * @param array $contacts Liste des contacts.
     * @return int Un ID valide de conversation.
     */
    private function ensureValidConversationId(int $conversationId, array $contacts): int
    {
        return ($conversationId === -1 && !empty($contacts)) ? $contacts[0]->getId() : $conversationId;
    }
}
