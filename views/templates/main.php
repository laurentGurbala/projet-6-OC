<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

$nbMessage = $_SESSION["nbMessages"] ?? 0;
$action = Utils::request("action", "home");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="css/styles.css">
    <script type="module" src="js/index.js"></script>
    <title><?= $title ?></title>
</head>

<body>
    <div class="main-container">
        <header>
            <div class="header-container">
                <!-- Navigation principal -->
                <div class="main-menu">
                    <!-- Logo -->
                    <a href="index.php" class="logo" aria-label="Retour à l'acceuil">
                        <img src="images/logos/logo_tom_troc.png" alt="Tom Troc">
                    </a>

                    <!-- Navigation desktop -->
                    <nav class="desktop-menu" aria-label="Menu principal">
                        <ul>
                            <li><a class="link <?= ($action === 'home') ? 'link-active' : '' ?>" href="index.php">Accueil</a></li>
                            <li><a class="link <?= ($action === 'listBooks' || $action === 'single') ? 'link-active' : '' ?>" href="index.php?action=listBooks">Nos livres à l'échange</a></li>
                        </ul>
                    </nav>
                    <!-- Icon hamburger -->
                    <div class="hamburger-menu">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>

                <!-- Navigation mobile -->
                <nav class="mobile-menu">
                    <ul>
                        <li><a class="link <?= ($action === 'home') ? 'link-active' : '' ?>" href="index.php">Accueil</a></li>
                        <li><a class="link <?= ($action === 'listBooks' || $action === 'single') ? 'link-active' : '' ?>" href="#">Nos livres à l'échange</a></li>
                    </ul>
                </nav>
            </div>
            <div class="user-actions">
                <a class="link-notify <?= ($action === 'message') ? 'link-active' : '' ?>" href="index.php?action=message" aria-label="Accéder à la messagerie">
                    <i class="fa-regular fa-comment"></i> Messagerie
                    <?php if ($nbMessage > 0): ?>
                        <span class="flag-notify"><?= $nbMessage ?></span>
                    <?php endif; ?>
                </a>
                <a class="link <?= ($action === 'account' || $action === 'publicAccount') ? 'link-active' : '' ?>" href="index.php?action=account" aria-label="Mon compte"><i class="fa-regular fa-user"></i> Mon compte</a>
                <?php if (isset($_SESSION["user_id"]) && is_int($_SESSION["user_id"])): ?>
                    <a class="link <?= ($action === 'connection' || $action === "register") ? 'link-active' : '' ?>" href="index.php?action=connection" aria-label="Se connecter">Déconnexion</a>
                <?php else : ?>
                    <a class="link <?= ($action === 'connection' || $action === "register") ? 'link-active' : '' ?>" href="index.php?action=connection" aria-label="Se connecter">Connexion</a>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <?= $content ?>
        </main>

        <footer>
            <nav aria-label="Liens du bas de page">
                <ul class="footer-menu">
                    <li><a class="link" href="#">Politique de confidentialité</a></li>
                    <li><a class="link" href="#">Mentions légales</a></li>
                </ul>
            </nav>
            <p>Tom Troc©</p>
            <a href="index.php" class="footer-logo" aria-label="Retour à l'acceuil">
                <img src="images/logos/logo_tom_troc_simple.png" alt="Tom Troc">
            </a>
        </footer>
    </div>
</body>

</html>