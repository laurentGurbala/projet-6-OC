<?php

/**
 * Affichage de la vue Single Page, détail d'un livre
 */
?>

<!-- Lien de retour -->
<div class="single-header">
    <p class="text-mark single-link"><a href="index.php?action=listBooks">Nos livres</a> > <?= htmlspecialchars($book->getTitle()) ?></p>
</div>

<div class="single-container">
    <img class="single-img" src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="La photo de couverture du livre <?= htmlspecialchars($book->getTitle()) ?>">

    <section class="single-section">
        <div class="single-content">
            <!-- Titre -->
            <h1 class="title-primary"><?= htmlspecialchars($book->getTitle()) ?></h1>
            <!-- Autheur -->
            <p class="text-mark">par <?= htmlspecialchars($book->getAuthor()) ?></p>
            <!-- Séparateur -->
            <div class="separator"></div>
            <!-- Descrition -->
            <p class="single-subtitle">description</p>
            <p class="single-description">
                <?= nl2br(htmlspecialchars($book->getDescription())) ?>
            </p>
            <!-- Propriétaire -->
            <p class="single-subtitle">propriétaire</p>
            <div class="single-owner">
                <img src="<?= $owner->getProfileImage() ?>" alt="Photo de profil de <?= $owner->getLogin() ?>">
                <p><?= $owner->getLogin() ?></p>
            </div>

            <button class="btn btn-primary">Envoyer un message</button>
        </div>
    </section>
</div>