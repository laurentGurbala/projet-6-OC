<?php

/**
 * Affiche la page Nos Livres
 */
?>

<div class="section-books books-container">
    <div class="books-header">
        <h1 class="title-primary">Nos livres à l'échange</h1>
        <form class="search-container" method="GET" action="index.php">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="hidden" name="action" value="listBooks">
            <input class="books-search input-field" type="search" name="q" id="search-book" placeholder="Rechercher un livre" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        </form>

    </div>

    <?php if (empty($books)): ?>
        <p>Aucun livre disponible pour le moment.</p>
    <?php else: ?>
        <!-- list -->
        <div class="card-list">
            <?php foreach ($books as $book): ?>
                <?php $bookPhoto = !empty($book->getPhoto()) ? htmlspecialchars($book->getPhoto()) : "images/photos/checker.png"; ?>
                <div class="card">
                    <a href="index.php?action=single&bookId=<?= $book->getId() ?>">
                        <img class="card-image" src="<?= $bookPhoto ?>" alt="couverture du livre">
                        <div class="card-content">
                            <p class="card-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                            <p class="card-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                            <p class="card-meta text-mark text-italic">Vendu par <?= htmlspecialchars($book->getSellerPseudo()) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>