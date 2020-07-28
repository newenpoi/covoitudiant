<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Search;

    class SearchController extends Controller
    {
        private $search = null;

        public function __construct()
        {
            $action = Helper::get_action($this);

            $this->search = new Search();
            
            $this->$action();
        }

        public function index()
        {
            echo $this->render('search/index.php');
        }

        public function find()
        {
            // Le lieu de départ et de destination (string).
            $departure = filter_input(INPUT_POST, 'departure');
            $destination = filter_input(INPUT_POST, 'destination');

            // Les jours de planning.
            $days = filter_input(INPUT_POST, 'days', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            // Heure de départ et de retour souhaité.
            $dep_time = filter_input(INPUT_POST, 'dep_time');
            $ret_time = filter_input(INPUT_POST, 'ret_time');

            $duration = filter_input(INPUT_POST, 'duration');
            $duration = date('H:i:s', strtotime("+$duration minutes", strtotime($dep_time)));

            $id_depart = $this->search->find_city_id($departure);
            $id_dest = $this->search->find_city_id($destination);

            $days = Helper::get_availabilities($days);
            
            $result = $this->search->find($id_depart, $id_dest, $days, $dep_time, $ret_time);

            echo $this->render('search/result.php', array('result' => $result, 'ville_depart' => $departure, 'ville_dest' => $destination));
        }

        public function accept()
        {
			$parameters = Helper::get_param('parameters');

			$parameters = explode(':', $parameters);

			$id_trajet = $parameters[0];
			$prenom = $parameters[1];

            $this->search->accept_ride($id_trajet);

            echo $this->render('search/done.php', array('prenom' => $prenom));
        }
    }