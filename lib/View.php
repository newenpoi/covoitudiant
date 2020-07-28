<?php
    namespace Covoitudiant\Lib;
    
    class View
    {
        private $path = '../view/';
        
        public $data = null;
        
        public function __construct($parameters)
        {
            /*
                $data sera accessible dans la vue.
            */

            $this->data = $parameters;
        }

        public function render($file)
        {
            ob_start();
            
            require ($this->path . $file);

            $this->content = ob_get_clean();

            require ('../view/base.php');
        }
    }

