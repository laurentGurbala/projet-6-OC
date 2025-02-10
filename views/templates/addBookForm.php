<!-- Formulaire -->
<section class="add-book-container">
    <a class="text-mark edit-back" href="index.php?action=account"><i class="fa-solid fa-arrow-left"></i> retour</a>
    <h1 class="title-primary">Ajouter un livre</h1>

    <div class="add-book-card">
        <!-- Image du livre -->
        <div class="add-book-image">
            <p class="text-mark add-book-subtitle">photo</p>
            <img src="images/photos/checker.png" alt="">
            <p class="add-book-modify" id="openModalBtn">modifier la photo</p>
        </div>

        <!-- Formulaire d'édition du livre -->
        <form class="add-book-form" action="index.php?action=createBook" method="POST" enctype="multipart/form-data">
            <!-- Title -->
            <div class="form-group">
                <label class="input-label" for="title">Titre</label>
                <input class="input-field input-field-secondary" type="text" id="title" name="title" required>
            </div>

            <!-- Author -->
            <div class="form-group">
                <label class="input-label" for="author">Author</label>
                <input class="input-field input-field-secondary" type="text" id="author" name="author" required>
            </div>

            <!-- Commentaire -->
            <div class="form-group">
                <label class="input-label" for="description">Commentaire</label>
                <textarea class="input-field input-field-secondary add-book-textarea" name="description" id="description"></textarea>
            </div>

            <!-- Disponibilité -->
            <div class="form-group">
                <label class="input-label" for="availability">Disponibilité</label>
                <select class="input-field input-field-secondary" id="availability" name="availability">
                    <option value="1" selected>Disponible</option>
                    <option value="0">Non disponible</option>
                </select>
            </div>

            <!-- Champ pour l'image (à soumettre avec le formulaire principal) -->
            <input type="hidden" name="profileImageBase64" id="profileImageBase64">

            <button class="btn btn-primary add-book-btn" type="submit">Valider</button>
        </form>
    </div>
</section>

<!-- Modale pour l'upload de l'image -->
<div class="modal" id="uploadModal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2 class="modal-title">Changer votre image du livre</h2>
        <form class="form-container" id="uploadBookForm">
            <div>
                <label for="profileImage">Choisissez une image :</label>
                <input type="file" name="profileImage" id="profileImage" accept="image/*" required>
            </div>
            <div class="error-message" id="errorMessage"></div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>