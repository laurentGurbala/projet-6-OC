<?php

/**
 * Affiche la page d'inscription
 */

?>

<div class="container">
    <div class="form-container">
        <h1>Inscription</h1>
        <form action="index.php?action=registerUser" method="post">
            <!-- Pseudo -->
            <div class="form-group">
                <label for="login">Pseudo</label>
                <input type="text" id="login" name="login" required>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <button class="btn btn-primary" type="submit">S'inscrire</button>
        </form>

        <!-- Déjà inscrit -->
        <div class="link">
            <p>Déjà inscrit ? <a href="index.php?action=connection">Connectez-vous</a></p>
        </div>
    </div>
    <div class="image-container" aria-hidden="true"></div>
</div>