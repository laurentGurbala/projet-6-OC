<?php

/**
 * Affihche la page public d'un compte utilisateur
 */
function formatDuration(DateTime $date): string
{
    $now = new DateTime();
    $interval = $now->diff($date);

    $duration = "";

    if ($interval->y > 0) {
        $duration .= $interval->y . " ans ";
    }

    if ($interval->m > 0) {
        $duration .= $interval->m . " mois ";
    }

    if ($interval->d > 0) {
        $duration .= $interval->d . " jours";
    }

    return trim($duration);
}
?>


<div class="public-container">
    <!-- Profil -->
    <section class="public-profil">
        <img src="<?= htmlspecialchars($owner->getProfileImage()) ?>" alt="" class="profil-image">
        <div class="separator"></div>
        <h1 class="title-primary"><?= htmlspecialchars($owner->getLogin()) ?></h1>
        <p class="profil-date">Membre depuis <?= formatDuration($owner->getCreatedAt()) ?></p>
        <p class="profil-library">BIBLIOTHEQUE</p>
        <div class="profil-nb-book">
            <img src="./images/svg/book.svg" alt="logo de 2 livres">
            <p><?= $bookCount ?> livres</p>
        </div>
        <button type="button" class="btn btn-alt">Écrire un message</button>
    </section>

    <!-- Liste des livres -->
    <div class="public-list">
        <?php if (!empty($books)): ?>
            <!-- En-tête -->
            <div class="list-header">
                <div class="list-cell">
                    <p>photo</p>
                </div>
                <div class="list-cell">
                    <p>Titre</p>
                </div>
                <div class="list-cell">
                    <p>Auteur</p>
                </div>
                <div class="list-cell">
                    <p>Description</p>
                </div>
            </div>

            <?php foreach ($books as $book): ?>
                <div class="list-row">
                    <div class="list-row-header">
                        <div class="list-row-image">
                            <img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>">
                        </div>
                        <div class="list-row-details">
                            <p><?= htmlspecialchars($book->getTitle()) ?></p>
                            <p><?= htmlspecialchars($book->getAuthor()) ?></p>
                        </div>
                    </div>
                    <div class="list-row-description">
                        <p class="italic"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>