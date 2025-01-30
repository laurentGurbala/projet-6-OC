<?php

/**
 * Affiche la page public d'un compte utilisateur
 */
?>


<div class="public-container">
    <!-- Profil -->
    <section class="profil">
        <img src="<?= htmlspecialchars($owner->getProfileImage()) ?>" alt="" class="profil-image">
        <div class="separator"></div>
        <h1 class="profil-title"><?= htmlspecialchars($owner->getLogin()) ?></h1>
        <p class="profil-date">Membre depuis <?= Utils::formatDuration($owner->getCreatedAt()) ?></p>
        <p class="profil-library">bibliotheque</p>
        <div class="profil-nb-book">
            <img src="./images/svg/book.svg" alt="logo de 2 livres">
            <p><?= $bookCount ?> livres</p>
        </div>
        <button type="button" class="btn btn-alt">Écrire un message</button>
    </section>

    <!-- Liste des livres -->
    <div class="book-list">
        <?php if (!empty($books)): ?>
            <!-- En-tête -->
            <div class="book-list-header">
                <div class="book-list-cell">
                    <p>photo</p>
                </div>
                <div class="book-list-cell">
                    <p>Titre</p>
                </div>
                <div class="book-list-cell">
                    <p>Auteur</p>
                </div>
                <div class="book-list-cell">
                    <p>Description</p>
                </div>
            </div>

            <!-- Row -->
            <?php foreach ($books as $book): ?>
                <div class="book-list-row">
                    <div class="book-list-content">
                        <div class="book-list-image">
                            <img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>">
                        </div>

                        <div class="book-list-details">
                            <p class="book-list-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                            <p class="book-list-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                        </div>

                    </div>

                    <div class="book-list-description">
                        <p class="text-italic"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>