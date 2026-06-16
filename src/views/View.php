<?php

namespace App\Views;

/**
 * Cette classe génère les vues en fonction de ce que chaque contrôlleur lui passe en paramètre. 
 */
class View 
{
    /**
     * Le titre de la page.
     */
    private string $title;
    
    
    /**
     * Constructeur. 
     */
    public function __construct(string $title) 
    {
        $this->title = $title;
    }
    
    /**
     * Cette méthode retourne une page complète. 
     * @param string $viewPath : le chemin de la vue demandée par le controlleur. 
     * @param array $params : les paramètres que le controlleur a envoyé à la vue.
     * @return string
     */
    public function render(string $viewName, array $params = []) : void 
    {
        $viewPath = $this->buildViewPath($viewName);

    $params['title'] = $this->title;
    $params['content'] = $this->_renderViewFromTemplate($viewPath, $params);

    extract($params);

    require MAIN_VIEW_PATH;
    }
    
    /**
     * Coeur de la classe, c'est ici qu'est généré ce que le controlleur a demandé. 
     * @param $viewPath : le chemin de la vue demandée par le controlleur.
     * @param array $params : les paramètres que le controlleur a envoyés à la vue.
     * @throws \Exception : si la vue n'existe pas.
     * @return string : le contenu de la vue.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {  
        if (file_exists($viewPath)) {
            extract($params); // On transforme les diverses variables stockées dans le tableau "params" en véritables variables qui pourront être lues dans le template.
            ob_start();
            require($viewPath);
            return ob_get_clean();
        } else {
            throw new \Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Cette méthode construit le chemin vers la vue demandée.
     * @param string $viewName : le nom de la vue demandée.
     * @return string : le chemin vers la vue demandée.
     */
    private function buildViewPath(string $viewName) : string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}



