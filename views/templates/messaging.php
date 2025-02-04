<?php

/**
 * La vue des messages
 */

function formatMessageDate(DateTime $date): string
{
    $today = new DateTime('today');

    if ($date >= $today) {
        return $date->format("H:i");
    } else {
        return $date->format("d.m");
    }
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
                                <p class="conversation-item__date"><?= formatMessageDate($lastMessage->getSentAt()) ?></p>
                            </div>
                            <p class="conversation-item__message text-mark"><?= htmlspecialchars($lastMessage->getContent()) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </section>
    <div class="conversation"></div>
</div>