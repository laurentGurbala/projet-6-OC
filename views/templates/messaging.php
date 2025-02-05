<?php

/**
 * La vue des messages
 */

function formatConversationDate(DateTime $date): string
{
    $today = new DateTime('today');

    if ($date >= $today) {
        return $date->format("H:i");
    } else {
        return $date->format("d.m");
    }
}

function getMessageClass($message): string
{
    return $message->getSenderId() === $_SESSION["user_id"] ? 'sent' : 'received';
}

function formatMessageDate(DateTime $dateTime): string
{
    return $dateTime->format("d.m H:i");
}
?>

<div class="messaging-container">
    <!-- Aside de la messagerie -->
    <section class="messaging">
        <!-- Titre -->
        <div class="messaging-header">
            <h1 class="messaging-title title-primary">Messagerie</h1>
        </div>

        <!-- Liste des conversations -->
        <div class="conversation-container">
            <?php foreach ($contacts as $contact):
                $lastMessage = $lastMessages[$contact->getId()];
            ?>
                <a href="index.php?action=message&conversationId=<?= $contact->getId() ?>">
                    <div class="conversation-item <?= $contact->getId() == $conversationId ? "conversation-item--active" : "" ?>">
                        <img class="conversation-item__avatar" src="<?= htmlspecialchars($contact->getProfileImage()) ?>" alt="Photo du profil de <?= htmlspecialchars($contact->getLogin()) ?>">
                        <div class="conversation-item__content">
                            <div class="conversation-item__details">
                                <p class="conversation-item__name"><?= htmlspecialchars($contact->getLogin()) ?></p>
                                <p class="conversation-item__date"><?= formatConversationDate($lastMessage->getSentAt()) ?></p>
                            </div>
                            <p class="conversation-item__message text-mark"><?= htmlspecialchars($lastMessage->getContent()) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </section>

    <!-- Aside des messages -->
    <div class="conversation">
        <!-- Profil du contact -->
        <div class="conversation-profil">
            <img class="conversation-profil__image" src="<?= htmlspecialchars($currentContact->getProfileImage()) ?>" alt="Photo du profil de <?= htmlspecialchars($currentContact->getLogin()) ?>">
            <p class="conversation-profil__name"><?= htmlspecialchars($currentContact->getLogin()) ?></p>
        </div>

        <!-- Conteneur des messages -->
        <div class="conversation-messages">
            <?php foreach ($conversationMessages as $message): ?>
                <div class="message <?= getMessageClass($message) ?>">
                    <span class="timestamp text-mark <?= getMessageClass($message) ?>"><?= formatMessageDate($message->getSentAt()) ?></span>
                    <p class="message-content <?= getMessageClass($message) ?>"><?= htmlspecialchars($message->getContent()) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>