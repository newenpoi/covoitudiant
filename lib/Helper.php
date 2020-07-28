<?php
	namespace Covoitudiant\Lib;

	class Helper
	{
		public static function sanitize($input)
		{
			return (filter_var($input, FILTER_SANITIZE_STRING));
		}

		public static function passwd_verif($input)
		{
            // Aucune restriction de mot de passe en cas de test local.
            if (self::is_local() && strlen($input) >= 4) { return true; }
            
            $expression = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/";
            
            return (preg_match($expression, $input) ? true : false);
		}
        
        public static function is_local()
        {
            if (self::sanitize($_SERVER['REMOTE_ADDR']) == "127.0.0.1" || self::sanitize($_SERVER['REMOTE_ADDR']) == "::1") { return true; }
            return false;
        }
        
        public static function is_valid($action, $controller)
        {
            $actions = array();

            /*
                Actions autorisées pour chaque contrôleur.
            */
            switch ($controller)
            {
                case 'admin':
                    $actions = ['register', 'login', 'logout'];
                break;
                case 'ajax':
                    $actions = ['add_formation', 'aff_user', 'autocomplete'];
                break;
                case 'panel':
                    $actions = ['logout'];
                break;
                case 'register':
                    $actions = ['register', 'verify', 'complete'];
                break;
                case 'user':
                    $actions = ['login', 'logout'];
                break;
                case 'profile':
                    $actions = ['switch'];
                break;
                default:
                    return false;
            }
            
            // Retire l'action login pour les pages dont l'authentification est nécessaire si l'utilisateur est déjà connecté.
            if (isset($_SESSION['id']) && in_array($controller, array('admin', 'user'))) { array_diff($actions, array('login')); }

            // Renvoie l'action si elle figure parmi la liste.
            if (in_array($action, $actions)) { return $action; }
            
            return false;
        }
        
        public static function get_action($controller)
        {
            /*
                Récupère l'action si elle est valide sur le contrôleur.
            */
            
            $action = filter_input(INPUT_GET, 'action');
            
            return (method_exists($controller, $action) ? $action : 'index');
        }

        public static function get_param($name)
        {
            $parameter = filter_input(INPUT_GET, $name);
            
            return $parameter;
        }

        public static function inform($email, $token)
        {
            return true;

            $link = "http://localhost/covoitudiant/register/verify/$email:$token";

            $to = 'pihet.christopher@gmail.com';

            $subject = 'Bienvenue !';

            $message = "Vous pouvez désormais compléter votre profil à l'adresse suivante : {$link}.";

            $headers = 'From: webmaster@newenpoi.gg' . "\r\n" .
                'Reply-To: webmaster@newenpoi.gg' . "\r\n" .
                'X-Mailer: PHP/' . phpversion()
            ;

            mail($to, $subject, $message, $headers);
        }

        public static function send_new_password($email, $new_password)
        {
            return true;
        }

        public static function get_availabilities($avails)
        {
            $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

            $output = array();

            foreach ($days as $key => $day)
            {
                if (in_array($day, $avails))
                {
                    $output[$days[$key]] = 1;
                }
                else
                {
                    $output[$days[$key]] = 0;
                }
            }

            return $output;
        }

        public static function logout()
        {
            session_destroy();
            header('Location: index.php');
        }
	}