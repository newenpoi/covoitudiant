<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
	use Covoitudiant\Lib\Helper;
    
    use Covoitudiant\Model\User;
    
    class UserController extends Controller
    {
        private $user;
        
        public function __construct()
        {
			$this->user = new User();
            
            $action = Helper::get_action($this);
            
            $this->$action();
        }
        
        public function index()
        {
			/*
				Renvoie vers la connexion si l'utilisateur n'est pas connecté, autrement vers l'édition de profil.
			*/
			
			if (isset($_SESSION['id']))
            {
                header('Location: index.php?page=profile');
            }
            else
            {
                $this->render('login/index.php');
            }
        }

		public function login()
		{
			$errors = array();
		
			$email = filter_input(INPUT_POST, 'email');
			$passwd = filter_input(INPUT_POST, 'passwd');
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "l'Adresse email est invalide.";
			}
            
			if (!Helper::passwd_verif($passwd))
			{
				$errors[] = "Ce mot de passe n'est pas acceptable.";
			}

			if (count($errors))
			{
				$this->render('login/index.php', $errors);
			}
			else
			{
				$result = $this->user->login($email);

				/*
					Renvoie sur l'index si l'authentification est réussie.
				*/

				if (password_verify($passwd, $result['passwd']))
				{
					$_SESSION['id'] = $result['id'];

					$this->render('home/index.php');
				}
				else
				{
					$this->render('login/index.php', array("Le nom d'utilisateur ou le mot de passe ne correspondent pas."));
				}
			}
        }
        
        public function logout()
        {
            Helper::logout();
        }
    }
