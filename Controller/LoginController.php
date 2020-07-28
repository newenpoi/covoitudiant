<?php
    namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
	use Covoitudiant\Lib\Helper;
    
	use Covoitudiant\Model\User;
    
	class LoginController extends Controller
	{
		private $errors = array();
		private $user = null;

		public function __construct()
		{
			// Appelle le modèle utilisateur.
			$this->user = new User();
			
			// Récupère l'action demandée.
            $action = Helper::get_action($this);
            
            $this->$action();
		}
		
		public function index()
		{
			$this->render('login/index.php');
		}
		
		public function connect()
		{
			$email = filter_input(INPUT_POST, 'email');
			$passwd = filter_input(INPUT_POST, 'passwd');
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$this->errors[] = "l'Adresse email est invalide.";
			}
            
			if (!Helper::passwd_verif($passwd))
			{
				$this->errors[] = "Ce mot de passe n'est pas acceptable.";
			}

			if (count($this->errors))
			{
				$this->render('login/index.php', array('errors' => $this->errors));
			}
			else
			{
				$result = $this->user->login($email, $passwd);
				
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
					$this->errors[] = "Le nom d'utilisateur ou le mot de passe ne correspondent pas.";
					
					$this->render('login/index.php', array('errors' => $this->errors));
				}
			}
		}
	}