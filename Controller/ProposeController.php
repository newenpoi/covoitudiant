<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Propose;

    class ProposeController extends Controller
    {
        private $propose = null;

        public function __construct()
        {
            $action = Helper::get_action($this);

            $this->propose = new Propose();
            
            $this->$action();
        }

        public function index()
        {
            echo $this->render('propose/index.php');
        }

        public function add_proposition()
        {
            /*
                Il faut être connecté.
            */

            if (!isset($_SESSION['id']))
            {
                header('Location: /login');
                die();
            }

            /*
                Le renvoie vers la page de profil s'il n'a pas spécifié de véhicule.
            */

            if (!$this->propose->has_vehicle())
            {
                echo $this->render('propose/index.php', array('error' => "Tu dois d'abord enregistrer ton véhicule si tu souhaites covoiturer."));
            }
            else
            {
                // Vérifions s'il propose déjà un trajet (on ne peut pas être à deux endroits en même temps en tant qu'étudiant).

                if ($this->propose->has_ride())
                {
                    echo $this->render('propose/index.php', array('error' => "Tu proposes déjà un trajet !"));
                }
                else
                {
                    // On filtre toutes les données.

                    $departure = filter_input(INPUT_POST, 'departure');
                    $destination = filter_input(INPUT_POST, 'destination');
                    $days = filter_input(INPUT_POST, 'days', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    $dep_time = filter_input(INPUT_POST, 'dep_time');
                    $ret_time = filter_input(INPUT_POST, 'ret_time');
                    $duration = filter_input(INPUT_POST, 'duration');
                    $nb_places = filter_input(INPUT_POST, 'nb_places');
                    $arrivee = date('H:i:s', strtotime("+$duration minutes", strtotime($dep_time)));
        
                    $id_depart = $this->propose->find_city_id($departure);
                    $id_dest = $this->propose->find_city_id($destination);
        
                    $days = Helper::get_availabilities($days);

                    // Ajoute le trajet.
                    
                    $this->propose->add_ride($id_depart, $id_dest, $nb_places, $days, $dep_time, $arrivee, $ret_time);
        
                    echo $this->render('propose/index.php', array('status' => 1));
                }
            }
        }
    }