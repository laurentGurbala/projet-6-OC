<?php

/**
 * Affiche la page d'inscription
 */

?>

<div class="auth-container">
    <div class="auth-form-container">
        <div>
            <h1 class="auth-form-title title-primary">Inscription</h1>
            <form class="auth-form" action="index.php?action=registerUser" method="post">
                <!-- Pseudo -->
                <div class="form-group">
                    <label for="login">Pseudo</label>
                    <input class="input-field" type="text" id="login" name="login" required>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input class="input-field" type="email" id="email" name="email" required>
                </div>
                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input class="input-field" type="password" id="password" name="password" required>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="error-message" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary" type="submit">S'inscrire</button>
            </form>
            <!-- Déjà inscrit -->
            <div class="auth-link">
                <p>Déjà inscrit ? <a class="text-underline" href="index.php?action=connection">Connectez-vous</a></p>
            </div>
        </div>
    </div>
    <div class="image-container" aria-hidden="true"></div>
</div>