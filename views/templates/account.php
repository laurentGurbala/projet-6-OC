<?php

/**
 * Affiche la page mon compte
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

function getProfileImagePath(User $user): string
{
    // Si l'utilisateur a une image, retourne son chemin
    if (!empty($user->getProfileImage())) {
        return htmlspecialchars($user->getProfileImage());
    }

    // Sinon, retourne le chemin de l'image par défaut
    return "./images/photos/checker.png";
}
?>

<section class="account-container">
    <h1 class="title-primary">Mon compte</h1>
    <div class="account-flex">
        <!-- profil -->
        <div class="profil">
            <div>
                <img class="profil-image" src="<?= getProfileImagePath($user) ?>" alt="Image de profil">
                <p class="profil-modify" id="openModalBtn">modifier</p>
            </div>
            <div class="separator"></div>
            <div class="profil-details">
                <h2 class="title-secondary profil-name"><?= $user->getLogin() ?></h2>
                <p class="profil-date">Membre depuis <?= formatDuration($user->getCreatedAt()) ?></p>
                <p class="profil-library">BIBLIOTHEQUE</p>
                <div class="profil-nb-book">
                    <img src="./images/svg/book.svg" alt="logo de 2 livres">
                    <p>4 livres</p>
                </div>
            </div>
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
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer">
                    </div>

                    <!-- Pseudo -->
                    <div class="form-group">
                        <label for="login">Pseudo</label>
                        <input type="text" id="login" name="login" value="<?= htmlspecialchars($user->getLogin()) ?>" required>
                    </div>

                    <!-- button -->
                    <button class="btn btn-alt" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste de livre en tableau -->
    <div class="table">
        <?php if (!empty($books)): ?>
            <div class="table-header">
                <div class="cell">
                    <p>Photo</p>
                </div>
                <div class="cell">
                    <p>Titre</p>
                </div>
                <div class="cell">
                    <p>Auteur</p>
                </div>
                <div class="cell">
                    <p>Description</p>
                </div>
                <div class="cell">
                    <p>Disponibilité</p>
                </div>
                <div class="cell">
                    <p>Action</p>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($books as $book) : ?>
            <div class="table-row">
                <div class="cell"><img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>"></div>
                <div class="cell">
                    <p><?= htmlspecialchars($book->getTitle()) ?></p>
                </div>
                <div class="cell">
                    <p><?= htmlspecialchars($book->getAuthor()) ?></p>
                </div>
                <div class="cell">
                    <p class="italic"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                </div>
                <div class="cell">
                    <p class="flag <?= $book->isAvailable() ? 'flag-dispo' : 'flag-no-dispo' ?>">
                        <?= $book->isAvailable() ? 'disponible' : 'non dispo.' ?>
                    </p>
                </div>
                <div class="cell action-cell">
                    <a class="edit" href="#">Éditer</a>
                    <a class="supr" href="#">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Liste de livre en card -->
    <div class="list-book">
        <!-- card -->
        <?php foreach ($books as $book): ?>
            <div class="card-list">
                <!-- En-tête de la card -->
                <div class="card-list-header">
                    <img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>">
                    <div class="card-list-infos">
                        <p class="card-list-title"><?= htmlspecialchars($book->getTitle()) ?></p>
                        <p class="card-list-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                        <p class="flag <?= $book->isAvailable() ? 'flag-dispo' : 'flag-no-dispo' ?>">
                            <?= $book->isAvailable() ? 'disponible' : 'non dispo.' ?>
                        </p>
                    </div>
                </div>
                <!-- Description de la card -->
                <p class="card-list-details"><?= htmlspecialchars($book->getDescription()) ?></p>
                <!-- Action de la card -->
                <div class="card-list-actions">
                    <a class="edit" href="#">Éditer</a>
                    <a class="supr" href="#">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
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