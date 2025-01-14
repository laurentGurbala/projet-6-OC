<?php

/**
 * Système d'autoload personnalisé.
 * 
 * À chaque fois que PHP a besoin d'une classe, il appelle cette fonction pour la charger automatiquement.
 * Cette fonction cherche les fichiers correspondants dans les dossiers `services`, `models`, `controllers` et `views`.
 * Si un fichier avec le même nom que la classe est trouvé, il est inclus avec `require_once`.
 */
spl_autoload_register(function ($className) {
    // Définition des dossiers à parcourir
    $directories = [
        'services/',
        'models/',
        'controllers/',
        'views/',
        "exceptions/",
    ];

    // Parcourt les dossiers pour rechercher la classe
    foreach ($directories as $directory) {
        $filePath = $directory . $className . '.php';

        // Si le fichier existe, on l'inclut et on arrête la recherche
        if (file_exists($filePath)) {
            require_once $filePath;
            return; // Arrêter le traitement une fois la classe trouvée
        }
    }

    // Message d'erreur si la classe n'est pas trouvée
    trigger_error("Impossible de charger la classe : $className", E_USER_WARNING);
});
