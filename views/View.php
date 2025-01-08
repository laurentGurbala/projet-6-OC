<?php

/**
 * Cette classe est responsable de la génération et de l'affichage des vues.
 * Elle reçoit des informations des contrôleurs et les transforme en contenu HTML complet
 * en intégrant des templates et des paramètres dynamiques.
 */
class View
{
    /**
     * @var string $title Le titre de la page (affiché dans l'onglet du navigateur).
     */
    private string $title;

    /**
     * Constructeur de la classe View.
     *
     * @param string $title Le titre de la page.
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Génère et affiche une page complète avec un template global.
     *
     * @param string $viewName Le nom de la vue demandée par le contrôleur (sans extension).
     * @param array $params Les paramètres que le contrôleur transmet à la vue
     *              sous forme de tableau associatif.
     * @return void
     */
    public function render(string $viewName, array $params = []): void
    {
        // Construit le chemin vers la vue
        $viewPath = $this->buildViewPath($viewName);

        // Génère le contenu à partir de la vue et des paramètres
        $content = $this->renderViewFromTemplate($viewPath, $params);
        $title = $this->title;

        // Capture la sortie du template principal
        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }

    /**
     * Génère le contenu de la vue demandée à partir d'un template.
     *
     * @param string $viewPath Le chemin complet vers le fichier de vue.
     * @param array $params Les paramètres transmis par le contrôleur à la vue.
     *              Chaque clé devient une variable accessible dans le template.
     * @throws Exception Si le fichier de vue n'existe pas.
     * @return string Le contenu généré par la vue.
     */
    private function renderViewFromTemplate(string $viewPath, array $params = []): string
    {
        if (file_exists($viewPath)) {
            // Transforme les clés du tableau $params en variables
            extract($params);

            // Capture le contenu généré par la vue
            ob_start();
            require($viewPath);
            return ob_get_clean();
        } else {
            throw new Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Construit le chemin complet vers le fichier de vue.
     *
     * @param string $viewName Le nom de la vue demandée (par exemple : 'home').
     * @return string Le chemin complet vers le fichier de vue.
     */
    private function buildViewPath(string $viewName): string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}
