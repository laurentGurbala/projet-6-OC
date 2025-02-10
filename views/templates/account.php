<?php

/**
 * Affiche la page mon compte
 */

function getProfileImagePath(User $user): string
{
    // Si l'utilisateur a une image, retourne son chemin
    if (!empty($user->getProfileImage())) {
        return htmlspecialchars($user->getProfileImage());
    }

    // Sinon, retourne le chemin de l'image par défaut
    return "./images/photos/checker.png";
}

function getAvailabilityClass(bool $isAvailable): string
{
    return $isAvailable ? 'flag--available' : 'flag--unavailable';
}

function getAvailabilityText(bool $isAvailable): string
{
    return $isAvailable ? 'disponible' : 'non dispo.';
}

?>

<section class="account-container">
    <h1 class="account-title title-primary">Mon compte</h1>
    <div class="account-flex">
        <!-- profil -->
        <div class="profil">
            <img class="profil-image" src="<?= getProfileImagePath($user) ?>" alt="Image de profil">
            <p class="profil-modify" id="openModalBtn">modifier</p>
            <div class="separator"></div>
            <h1 class="profil-title"><?= htmlspecialchars($user->getLogin()) ?></h1>
            <p class="profil-date">Membre depuis <?= Utils::formatDuration($user->getCreatedAt()) ?></p>
            <p class="profil-library">bibliotheque</p>
            <div class="profil-nb-book">
                <img src="./images/svg/book.svg" alt="logo de 2 livres">
                <p><?= $bookCount <= 1 ? $bookCount . ' livre' : $bookCount . ' livres' ?></p>
            </div>
            <p><a href="index.php?action=addBook">Ajouter un livre</a></p>
        </div>

        <!-- infos perso -->
        <div class="infos">
            <div class="infos-container">
                <!-- titre -->
                <p class="infos-title">Vos informations personnelles</p>

                <!-- formulaire -->
                <form class="infos-form" action="index.php?action=updateAccount" method="POST">
                    <!-- Email -->
                    <div class="form-group">
                        <label class="input-label" for="email">Adresse email</label>
                        <input class="input-field" type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label class="input-label" for="password">Mot de passe</label>
                        <input class="input-field" type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer">
                    </div>

                    <!-- Pseudo -->
                    <div class="form-group">
                        <label class="input-label" for="login">Pseudo</label>
                        <input class="input-field" type="text" id="login" name="login" value="<?= htmlspecialchars($user->getLogin()) ?>" required>
                    </div>

                    <!-- button -->
                    <button class="btn btn-alt" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des livres -->
    <div class="book-list book-list--large">
        <?php if (!empty($books)): ?>
            <!-- En-tête -->
            <div class="book-list-header">
                <div class="book-list-cell">
                    <p>Photo</p>
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
                <div class="book-list-cell">
                    <p>Disponibilité</p>
                </div>
                <div class="book-list-cell book-list-cell--actions">
                    <p>Action</p>
                </div>
            </div>

            <!-- Row -->
            <?php foreach ($books as $book) : ?>
                <div class="book-list-row">
                    <div class="book-list-content">
                        <div class="book-list-image"><img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>"></div>

                        <div class="book-list-details">
                            <p class="book-list-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                            <p class="book-list-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                        </div>

                    </div>

                    <div class="book-list-description">
                        <p class="text-italic"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                    </div>
                    <div class="book-list-flag">
                        <p class="flag <?= getAvailabilityClass($book->isAvailable()) ?>">
                            <?= getAvailabilityText($book->isAvailable()) ?>
                        </p>
                    </div>

                    <div class="book-list-actions">
                        <a class="text-underline" href="index.php?action=editBook&id=<?= $book->getId() ?>"
                            aria-label="Éditer le livre <?= htmlspecialchars($book->getTitle()) ?>">Éditer</a>

                        <a class="text-underline link-remove" href="index.php?action=deleteBook&id=<?= $book->getId() ?>"
                            aria-label="Supprimer le livre <?= htmlspecialchars($book->getTitle()) ?>"
                            <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce livre ?") ?>>Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="book-list--mobile">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <div class="book-list-row book-list-row--mobile">
                    <div class="book-list-content">
                        <div class="book-list-image">
                            <img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>">
                        </div>

                        <div class="book-list-details">
                            <p class="book-list-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                            <p class="book-list-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                            <p class="book-list-flag flag <?= getAvailabilityClass($book->isAvailable()) ?>">
                                <?= getAvailabilityText($book->isAvailable()) ?>
                            </p>
                        </div>

                    </div>

                    <div class="book-list-description">
                        <p class="text-italic"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                    </div>

                    <div class="book-list-actions">
                        <a class="text-underline" href="index.php?action=editBook&id=<?= htmlspecialchars($book->getId()) ?>"
                            aria-label="Éditer le livre <?= htmlspecialchars($book->getTitle()) ?>">Éditer</a>

                        <a class="text-underline link-remove" href="index.php?action=deleteBook&id=<?= htmlspecialchars($book->getId()) ?>"
                            aria-label="Supprimer le livre <?= htmlspecialchars($book->getTitle()) ?>"
                            <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce livre ?") ?>>Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Modale pour l'upload de l'image -->
<div class="modal" id="uploadModal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2 class="modal-title">Changer votre image de profil</h2>
        <form class="form-container" id="uploadProfileForm" method="POST" enctype="multipart/form-data">
            <div>
                <label for="profileImage">Choisissez une image :</label>
                <input type="file" name="profileImage" id="profileImage" accept="image/*" required>
            </div>
            <div class="error-message" id="errorMessage"></div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>