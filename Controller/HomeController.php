<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;

    class HomeController extends Controller
    {
        public function __construct()
        {
            $this->index();
        }

        public function index()
        {
            $rendered = number_format((microtime(true) - APP_START) * 1000, 3);

            echo $this->render('home/index.php', array('render' => $rendered));
        }
    }