<?php
    namespace Covoitudiant\Controller;

    use Covoitudiant\Lib\Controller;
    use Covoitudiant\Lib\Helper;

    use Covoitudiant\Model\Profile;

    class ProfileController extends Controller
    {
        private $profile;   
        private $errors;

        public function __construct()
        {
            /*
                Requière une élévation utilisateur.
            */

            if (!isset($_SESSION['id']))
                header('Location: index.php');
            
            $this->profile = new Profile();

            $action = Helper::get_action($this);
            
            $this->$action();
        }

        public function index()
        {
            echo $this->render('profile/edit.php', array('infos' => $this->profile->get_infos(), 'formations' => $this->profile->get_formations(), 'vehicle' => $this->profile->get_vehicle(), 'error' => $this->errors));
        }

        /*
            Voir le profil.
        */
        public function view()
        {
            $id_user = Helper::get_param('parameters');

            // Récupère les informations de ce profil.
            $infos = $this->profile->get_infos($id_user);

            if ($infos)
            {
                echo $this->render('profile/index.php', array('infos' => $infos, 'comments' => $this->profile->get_comments($id_user)));
            }
            else
            {
                echo $this->render('home/index.php');
            }
        }

        /*
            Changer de formation.
        */
        public function switch()
        {
            $id_formation = filter_input(INPUT_POST, 'id_formation');

            $result = $this->profile->switch_formation($id_formation);

            echo $this->render('profile/switch.php');
        }

        /*
            Ajouter un véhicule.
        */
        public function add_vehicle()
        {
            $mark = filter_input(INPUT_POST, 'marque');
            $color = filter_input(INPUT_POST, 'couleur');
            $places = filter_input(INPUT_POST, 'nb_places');
            $immat = filter_input(INPUT_POST, 'immat');

            $result = $this->profile->add_vehicle($mark, $color, $places, $immat);

            $this->index();
        }

        /*
            Supprimer un véhicule.
        */
        public function del_vehicle()
        {
            // Vérifions que nous n'avons pas de trajet(s) lié(s) à ce véhicule.
            $result = $this->profile->get_trajets($_SESSION['id']);

            if ($result)
            {
                $this->errors[] = "Vous ne pouvez pas supprimer un véhicule lié à un trajet.";
            }
            else
            {
                $this->profile->del_vehicle();
            }

            $this->index();
        }

        /*
            Éditer l'avatar.
        */
        public function edit_avatar()
        {
            if (isset($_FILES['file']['name']))
            {
                // Dimensions de la Miniature par Défaut.
                $thumb_w = 1024;
                $thumb_h = 768;

                // Informations du fichier.
                $f_name = basename($_FILES['file']['name']);
                $f_type = pathinfo($f_name, PATHINFO_EXTENSION);
                $n_name = time();

                $target_file = $_SERVER['DOCUMENT_ROOT'] . '/avatar/' . $n_name . '.' . $f_type;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file))
                {
                    // Le nom de fichier + l'extension.
                    $this->profile->edit_avatar($n_name . '.' . $f_type);

                    $this->index();
                }
                else
                {
                    $this->index();
                }
            }
            else
            {
                $this->index();
            }
        }

        /*
            Éditer la Biographie
        */
        public function edit_bio()
        {
            $bio = filter_input(INPUT_POST, 'biographie');

            $this->profile->edit_bio($bio);

            $this->index();
        }
    }