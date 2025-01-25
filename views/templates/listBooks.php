<?php

/**
 * Affiche la page Nos Livres
 */
?>

<div class="books-container">
    <div class="books-header">
        <h1 class="title-primary">Nos livres à l'échange</h1>
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" name="search-book" id="search-book" placeholder="Rechercher un livre">
        </div>
    </div>

    <?php if (empty($books)): ?>
        <p>Aucun livre disponible pour le moment.</p>
    <?php else: ?>
        <!-- list -->
        <div class="books-list">
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
</div>