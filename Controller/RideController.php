<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Ride;

    class RideController extends Controller
    {
        private $ride = null;

        public function __construct()
        {
            $action = Helper::get_action($this);

            $this->ride = new Ride();
            
            $this->$action();
        }

        public function index()
        {
            echo $this->render('ride/index.php', array('ride' => $this->ride->get_ride(), 'pending' => $this->ride->get_pending(), 'accepted' => $this->ride->get_accepted(), 'demand' => $this->ride->get_reserved()));
        }

        public function accept()
        {
            // Récupère l'identifiant de l'utilisateur et du trajet dont on accepte la réservation.
            $parameters = Helper::get_param('parameters');
            
            // La magie explosive, la plus puissante de toutes les magies !
			$parameters = explode(':', $parameters);

			$id_user = $parameters[0];
			$id_trajet = $parameters[1];

            $this->ride->accept($id_user, $id_trajet);

            $this->index();
        }

        /*
            Annule notre demande sur ce trajet.
        */
        public function cancel()
        {
            $id_trajet = Helper::get_param('parameters');

            $this->ride->cancel($id_trajet);

            $this->index();
        }

        public function delete()
        {
            $id_trajet = Helper::get_param('parameters');

            // Si des utilisateurs étaient affectés au trajet on récupère une réponse positive.
            $response = $this->ride->delete($id_trajet);

            // Informer les utilisateurs ayant réservé de la suppression du trajet.

            $this->index();
        }
    }