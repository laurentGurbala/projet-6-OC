<section class="edit-container">
    <a class="text-mark edit-back" href="index.php?action=account"><i class="fa-solid fa-arrow-left"></i> retour</a>
    <h1 class="title-primary edit-title">Modifier les informations</h1>

    <div class="edit-card">
        <!-- Image du livre -->
        <div class="edit-image">
            <img src="<?= htmlspecialchars($book->getPhoto()) ?>" alt="Photo du livre <?= htmlspecialchars($book->getTitle()) ?>">
            <p class="edit-modify" id="openModalBtn">modifier la photo</p>
        </div>

        <!-- Formulaire d'édition du livre -->
        <form class="edit-form" action="#" method="POST">
            <!-- Title -->
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($book->getTitle()) ?>" required>
            </div>

            <!-- Author -->
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($book->getAuthor()) ?>" required>
            </div>

            <!-- Commentaire -->
            <div class="form-group">
                <label for="description">Commentaire</label>
                <textarea class="edit-textarea" name="description" id="description"><?= htmlspecialchars($book->getDescription()) ?></textarea>
            </div>

            <div class="form-group">
                <label for="availability">Disponibilité</label>
                <select id="availability" name="availability" required>
                    <option value="1" <?= $book->isAvailable() ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= !$book->isAvailable() ? 'selected' : '' ?>>Non disponible</option>
                </select>
            </div>

            <button class="btn btn-primary edit-btn" type="submit">Valider</button>
        </form>
    </div>
</section>

<!-- Modale pour l'upload de l'image -->
<div class="modal" id="uploadModal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2 class="modal-title">Changer votre image du livre</h2>
        <form class="form-container" id="uploadBookForm" method="POST" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="bookId" value="<?= $book->getId() ?>">
                <label for="profileImage">Choisissez une image :</label>
                <input type="file" name="profileImage" id="profileImage" accept="image/*" required>
            </div>
            <div class="error-message" id="errorMessage"></div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>