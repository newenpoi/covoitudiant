<?php
    namespace Covoitudiant\Lib;

    use Covoitudiant\Lib\View;
    
    abstract class Controller
    {
        // Force les classes enfants à définir cette méthode.
        abstract protected function index();

        // Méthode commune.
        public function render($file, $parameters = null)
        {
            $view = new View($parameters);
            
            $view->render($file);
        }
    }
