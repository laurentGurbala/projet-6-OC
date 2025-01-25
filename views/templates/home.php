<?php

/**
 * Affiche la page principale
 */

?>
<!-- Bannière -->
<div class="banner">
    <!-- Section principale -->
    <section class="banner-section">
        <h1 class="title-primary">Rejoignez nos lecteurs passionnés</h1>
        <p class="banner-detail">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>
        <a href="#" class="btn btn-primary">Découvrir</a>
    </section>

    <!-- Section image -->
    <div class="banner-image">
        <img src="./images/photos/homepage_1.jpg" alt="Un vieil homme assis entrain de lire au milieu de son exposition de livre.">
        <p class="text-mark italic">Hamza</p>
    </div>
</div>

<!-- Dernière ajouts -->
<section class="ajout">
    <!-- Titre -->
    <h2 class="title-secondary">Les derniers livres ajoutés</h2>

    <?php if (empty($books)): ?>
        <p>Aucun livre disponible pour le moment.</p>
    <?php else: ?>
        <!-- list -->
        <div class="ajout-list">
            <?php foreach ($books as $book): ?>
                <div class="card-book">
                    <img class="card-book-img" src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="couverture du livre">
                    <div class="card-book-details">
                        <p class="card-book-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                        <p class="card-book-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                        <p class="card-book-pseudo text-mark italic">Vendu par <?= htmlspecialchars($book->getSellerPseudo()) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- button -->
    <a class="btn btn-primary" href="index.php?action=listBooks">Voir tous les livres</a>
</section>

<!-- Comment ça marche -->
<section class="fonctionnement">
    <!--Titre  -->
    <h2 class="title-secondary">Comment ça marche ?</h2>

    <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>

    <!-- list -->
    <div class="fonctionnement-list">
        <!-- step 1 -->
        <div class="fonctionnement-step">
            <p>Inscrivez-vous gratuitement sur<br> notre plateforme.</p>
        </div>

        <!-- step 2 -->
        <div class="fonctionnement-step">
            <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
        </div>

        <!-- step 3 -->
        <div class="fonctionnement-step">
            <p>Parcourez les livres disponibles chez d'autres membres.</p>
        </div>

        <!-- step 4 -->
        <div class="fonctionnement-step">
            <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
        </div>
    </div>

    <!-- button -->
    <a href="#" class="btn btn-alt">Voir tous les livres</a>
</section>

<!-- img -->
<div class="separator-img" aria-hidden="true"></div>

<!-- Nos valeurs -->
<section class="valeurs">
    <div>
        <h2 class="title-secondary">Nos valeurs</h2>
        <div class="valeurs-text">
            <p>
                Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos
                valeurs sont ancrées dans notre passion pour les
                livres et notre désir de créer des liens entre les
                lecteurs. Nous croyons en la puissance des histoires
                pour rassembler les gens et inspirer des
                conversations enrichissantes.
            </p>
            <p>
                Notre association a été fondée avec une conviction
                profonde : chaque livre mérite d'être lu et partagé.
            </p>
            <p>
                Nous sommes passionnés par la création d'une
                plateforme conviviale qui permet aux lecteurs de se
                connecter, de partager leurs découvertes littéraires
                et d'échanger des livres qui attendent patiemment
                sur les étagères.
            </p>
        </div>
        <p class="text-mark">L'équipe Tom Troc</p>
        <img src="./images/svg/heart.svg" alt="Une signature en forme de coeur">
    </div>
</section>