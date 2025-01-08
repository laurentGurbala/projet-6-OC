<?php

/**
 * Classe utilitaire
 */
class Utils
{
    /**
     * Récupère la valeur d'une variable depuis la superglobale PHP $_REQUEST.
     *
     * Cette méthode permet de récupérer une variable passée par une requête HTTP (GET ou POST).
     * Si la variable n'est pas définie dans $_REQUEST, une valeur par défaut peut être spécifiée.
     *
     * @param string $variableName Nom de la variable à récupérer depuis $_REQUEST.
     * @param mixed $defaultValue Valeur par défaut à retourner si la variable n'existe pas (par défaut : null).
     * 
     * @return mixed La valeur de la variable si elle existe, sinon la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Redirige l'utilisateur vers une action spécifique avec des paramètres optionnels.
     *
     * Cette méthode génère une URL basée sur le paramètre `action` et les paramètres supplémentaires fournis.
     * Elle utilise la fonction `header` pour effectuer une redirection HTTP.
     *
     * @param string $action L'action vers laquelle rediriger (par exemple : 'home', 'connection').
     * @param array $params Un tableau associatif de paramètres supplémentaires à inclure dans l'URL.
     *                      Exemple : ['id' => 42, 'category' => 'books'].
     * 
     * @return void
     */
    public static function redirect(string $action, array $params = []): void
    {
        // Construction de l'URL avec l'action et les paramètres supplémentaires
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }

        // Redirection vers l'URL générée
        header("Location: $url");
        exit();
    }

    /**
     * Vérifie si l'utilisateur est connecté.
     *
     * Cette méthode vérifie la présence d'une session utilisateur (`$_SESSION["user"]`).
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
     * 
     * @return void
     */
    public static function checkIfUserIsConnected(): void
    {
        // Vérifie si la session utilisateur est active
        if (!isset($_SESSION["user"])) {
            // Redirige l'utilisateur vers la page de connexion
            Utils::redirect("connection");
        }
    }
}
