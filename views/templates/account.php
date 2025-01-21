<section class="account-container">
    <h1 class="title-primary">Mon compte</h1>
    <div class="account-flex">
        <!-- profil -->
        <div class="profil">
            <div>
                <img class="profil-image" src="./images/photos/checker.png" alt="Profil">
                <p class="profil-modify">modifier</p>
            </div>
            <div class="separator"></div>
            <div class="profil-details">
                <h2 class="title-secondary profil-name">nathalire</h2>
                <p class="profil-date">Membre depuis 1 an</p>
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
                        <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer" required>
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
        <div class="table-row">
            <div class="cell"><img src="./images/photos/checker.png" alt="Photo du livre"></div>
            <div class="cell">
                <p>auteur</p>
            </div>
            <div class="cell">
                <p>titre du livre</p>
            </div>
            <div class="cell">
                <p class="italic">J'ai récemment <br> plongé dans les pages <br> de 'The Kinfolk Table' <br> et j'ai été enchanté par</p>
            </div>
            <div class="cell">
                <p class="flag flag-dispo">disponible</p>
            </div>
            <div class="cell action-cell">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="table-row">
            <div class="cell"><img src="./images/photos/checker.png" alt="Photo du livre"></div>
            <div class="cell">
                <p>auteur</p>
            </div>
            <div class="cell">
                <p>titre du livre</p>
            </div>
            <div class="cell">
                <p class="italic">J'ai récemment <br> plongé dans les pages <br> de 'The Kinfolk Table' <br> et j'ai été enchanté par</p>
            </div>
            <div class="cell">
                <p class="flag flag-no-dispo">non dispo.</p>
            </div>
            <div class="cell action-cell">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="table-row">
            <div class="cell"><img src="./images/photos/checker.png" alt="Photo du livre"></div>
            <div class="cell">
                <p>auteur</p>
            </div>
            <div class="cell">
                <p>titre du livre</p>
            </div>
            <div class="cell">
                <p class="italic">J'ai récemment <br> plongé dans les pages <br> de 'The Kinfolk Table' <br> et j'ai été enchanté par</p>
            </div>
            <div class="cell">
                <p class="flag flag-no-dispo">non dispo.</p>
            </div>
            <div class="cell action-cell">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="table-row">
            <div class="cell"><img src="./images/photos/checker.png" alt="Photo du livre"></div>
            <div class="cell">
                <p>auteur</p>
            </div>
            <div class="cell">
                <p>titre du livre</p>
            </div>
            <div class="cell">
                <p class="italic">J'ai récemment <br> plongé dans les pages <br> de 'The Kinfolk Table' <br> et j'ai été enchanté par</p>
            </div>
            <div class="cell">
                <p class="flag flag-no-dispo">non dispo.</p>
            </div>
            <div class="cell action-cell">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>
    </div>

    <!-- Liste de livre en card -->
    <div class="list-book">
        <!-- card -->
        <div class="card-list">
            <!-- En-tête de la card -->
            <div class="card-list-header">
                <img src="./images/photos/checker.png" alt="Photo courverture">
                <div class="card-list-infos">
                    <p class="card-list-title">Titre du livre</p>
                    <p class="card-list-author">Auteur du livre</p>
                    <p class="flag flag-dispo">disponible</p>
                </div>
            </div>
            <!-- Description de la card -->
            <p class="card-list-details">
                J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre
            </p>
            <!-- Action de la card -->
            <div class="card-list-actions">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="card-list">
            <!-- En-tête de la card -->
            <div class="card-list-header">
                <img src="./images/photos/checker.png" alt="Photo courverture">
                <div class="card-list-infos">
                    <p class="card-list-title">Titre du livre</p>
                    <p class="card-list-author">Auteur du livre</p>
                    <p class="flag flag-dispo">disponible</p>
                </div>
            </div>
            <!-- Description de la card -->
            <p class="card-list-details">
                J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre
            </p>
            <!-- Action de la card -->
            <div class="card-list-actions">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="card-list">
            <!-- En-tête de la card -->
            <div class="card-list-header">
                <img src="./images/photos/checker.png" alt="Photo courverture">
                <div class="card-list-infos">
                    <p class="card-list-title">Titre du livre</p>
                    <p class="card-list-author">Auteur du livre</p>
                    <p class="flag flag-dispo">disponible</p>
                </div>
            </div>
            <!-- Description de la card -->
            <p class="card-list-details">
                J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre
            </p>
            <!-- Action de la card -->
            <div class="card-list-actions">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>

        <div class="card-list">
            <!-- En-tête de la card -->
            <div class="card-list-header">
                <img src="./images/photos/checker.png" alt="Photo courverture">
                <div class="card-list-infos">
                    <p class="card-list-title">Titre du livre</p>
                    <p class="card-list-author">Auteur du livre</p>
                    <p class="flag flag-dispo">disponible</p>
                </div>
            </div>
            <!-- Description de la card -->
            <p class="card-list-details">
                J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre
            </p>
            <!-- Action de la card -->
            <div class="card-list-actions">
                <a class="edit" href="#">Éditer</a>
                <a class="supr" href="#">Supprimer</a>
            </div>
        </div>
    </div>

</section>