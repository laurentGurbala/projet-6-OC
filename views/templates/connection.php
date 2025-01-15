<?php

/**
 * Affiche la page de connection
 */

?>

<div class="container">
    <div class="form-container">
        <h1>Connexion</h1>
        <form action="index.php?action=loginUser" method="post">
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
                <div class="error-message" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <button class="btn btn-primary" type="submit">S'inscrire</button>
        </form>

        <!-- Pas de compte -->
        <div class="link">
            <p>Pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a></p>
        </div>
    </div>

    <!-- Image (décorative) -->
    <div class="image-container" aria-hidden="true"></div>
</div>