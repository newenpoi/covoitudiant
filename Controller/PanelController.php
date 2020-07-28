<?php
    namespace Covoitudiant\Controller;

    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Panel;

    class PanelController extends Controller
    {
        public $panel;

        public function __construct()
        {
            /*
                Requière une élévation administrateur.
            */

            if (!isset($_SESSION['admin']))
            {
                header('Location: /');
                die();
            }

            $this->panel = new Panel();

            $action = Helper::get_action($this);
            
            $this->$action();
        }

        public function index()
        {
            echo $this->render('panel/index.php', array('formations' => $this->panel->get_formations(), 'pending' => $this->panel->get_pending(), 'validated' => $this->panel->get_validated(), 'switch' => $this->panel->get_switch()));
        }

        public function logout()
        {
            Helper::logout();
        }
    }