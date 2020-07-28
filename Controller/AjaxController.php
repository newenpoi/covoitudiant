<?php
	namespace Covoitudiant\Controller;

    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Ajax;
    
    class AjaxController extends Controller
    {
        private $ajax = null;

        public function __construct()
        {
            // Nettoie le buffer (afin d'éviter de fausser le résultat).
            ob_clean();

            $this->ajax = new Ajax();
            
            $action = Helper::get_action($this);
            
            $this->$action();
        }

        public function index()
        {
            // Par défaut je souhaite que le contrôleur ajax retournera false si aucune action n'a été accomplie.
            return false;
        }

        public function autocomplete()
        {
			$input = Helper::get_param('parameters');

            $cities = $this->ajax->get_cities();
	
            $response = array();
            
            foreach ($cities as $city)
            {
                if (strtoupper(substr($city['ville_nom_reel'], 0, strlen($input))) == strtoupper($input))
                {
                    // Lat & Lon nécessaires pour le routing.
                    array_push($response, array('city' => $city['ville_nom_reel'], 'lat' => $city['ville_latitude_deg'], 'lon' => $city['ville_longitude_deg']));
                }
            }

            echo json_encode($response);
        }

        public function addFormation()
        {
            $name = filter_input(INPUT_POST, 'input');
            
            $result = $this->ajax->add_formation($name);
            
            echo ($result ? true : false);
        }

        public function affUser()
        {
            $email = filter_input(INPUT_POST, 'email');
            $id_formation = filter_input(INPUT_POST, 'id_formation');

            // Affecter l'Utilisateur à sa Formation.
            $result = $this->ajax->aff_user($email, $id_formation);

            // Récupère le jeton.
            $token = $this->ajax->get_token($email);

            // Envoi un mail invitant l'utilisateur à se connecter uniquement si le token existe bel et bien.
            if ($token)
            {
                Helper::inform($email, $token);
            }

            echo ($result && $token ? true : false);
        }

        public function reaffUser()
        {
            $email = filter_input(INPUT_POST, 'email');
            $id_formation = filter_input(INPUT_POST, 'id_formation');

            $result = $this->ajax->reaffect($email, $id_formation);

            echo ($result ? true : false);
        }

		public function addAdmin()
		{
			$email = filter_input(INPUT_POST, 'email');

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "l'Adresse email est invalide.";
			}

			if (!count($errors))
			{
                $this->ajax->add_admin($email);
			}
            
            echo (!count($errors) ? true : false);
        }
    }