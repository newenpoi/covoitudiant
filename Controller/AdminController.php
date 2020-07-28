<?php
	namespace Covoitudiant\Controller;

    use Covoitudiant\Lib\Controller;
	use Covoitudiant\Lib\Helper;
    
	use Covoitudiant\Model\Admin;
	
	class AdminController extends Controller
	{
		private $admin = null;
		
		public function __construct()
		{
			$this->admin = new Admin();
            
			$action = Helper::get_action($this);
            
            $this->$action();
		}
		
		public function index()
		{
			/*
				Renvoie vers le formulaire d'enregistrement d'administrateur si aucun n'existe.
			*/
			
			if (isset($_SESSION['id']))
            {
                header('Location: /panel');
			}
			else
			{
				echo ($this->admin->any() ? $this->render('admin/login.php') : $this->render('admin/create.php'));
			}
		}
		
		public function register()
		{
			/*
				Création d'un administrateur lambda.
			*/

			$errors = array();
		
			$email = filter_input(INPUT_POST, 'email');
			$passwd = filter_input(INPUT_POST, 'passwd');
			$passwd_repeat = filter_input(INPUT_POST, 'passwd_repeat');
			$secret_question = filter_input(INPUT_POST, 'secret_question');
			$secret_answer = filter_input(INPUT_POST, 'secret_answer');
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "l'Adresse email est invalide.";
			}
			
			if (!Helper::passwd_verif($passwd))
			{
				$errors[] = "Ce mot de passe n'est pas acceptable.";
			}
			
			if ($passwd != $passwd_repeat)
			{
				$errors[] = "Les mots de passe ne sont pas identiques.";
			}
			
			if (strlen($secret_question) < 3 || strlen($secret_question) > 64)
			{
				$errors[] = "Votre question secrète personnalisée est trop courte ou trop longue.";
			}
			
			if (strlen($secret_answer) < 3 || strlen($secret_answer) > 255)
			{
				$errors[] = "La réponse à votre question secrète est trop courte ou trop longue (faut pas charier).";
			}
			
			/*
				On passe si aucune erreurs.
			*/

			if (!count($errors))
			{
				$this->admin->add($email, $passwd, $secret_question, $secret_answer);
                
                header('Location: /admin');
			}
            else
            {
                echo $this->render('admin/create.php', array('errors' => $errors));
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
			
			/*
				Renvoie sur le Tableau de Bord si l'authentification est réussie.
			*/

			$result = $this->admin->login($email, $passwd);

            if (password_verify($passwd, $result['passwd']))
            {
                $_SESSION['admin'] = $result['id'];
				
                header('Location: /panel');
            }
            else
            {
                echo $this->render('admin/login.php', array('errors' => $errors));
            }
		}
		
		public function recover()
		{
			$errors = array();

			$email = filter_input(INPUT_POST, 'email');
			$secret_question = filter_input(INPUT_POST, 'secret_question');
			$secret_answer = filter_input(INPUT_POST, 'secret_answer');

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$errors[] = "l'Adresse email est invalide.";
			}

			if (empty($secret_question) || empty($secret_answer))
			{
				$errors[] = "Votre question ou réponse secrète n'est pas conforme.";
			}

			if (!count($errors))
			{
				// Renvoie l'email de l'admin, si l'email, la question et la réponse secrète coincident.
				$email = $this->admin->recoverable($email, $secret_question, $secret_answer);

				if ($email)
				{
					// Création d'un nouveau jeton en attente de confirmation.
					$token = substr(md5(uniqid(rand(), true)), 16, 16);

					$this->admin->recover($email, $token);

					// Envoi de l'email avec le lien de récupération.
					Helper::inform($email, $token);
				}

				echo $this->render('admin/recover.php');
			}
			else
			{
				echo $this->render('admin/login.php', array('errors' => $errors));
			}
		}

		public function change()
		{
			/*
				Changer le mot de passe admin.
			*/

			$parameters = Helper::get_param('parameters');

			$parameters = explode(':', $parameters);

			$email = $parameters[0];
			$token = $parameters[1];

			if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $this->admin->verify($email, $token) == false)
			{
				echo $this->render('home/index.php');
			}
			else
			{
				// Génère un nouveau mot de passe de huit caractères aléatoires.
				$password = substr(md5(uniqid(rand(), true)), 8, 8);

				// Ajoute le nouveau mot de passe à la base de données.
				$this->admin->change_password($email, $password);

				// Envoi du nouveau mot de passe par email.
				Helper::send_new_password($email, $password);

				echo $this->render('admin/changed.php');
			}
		}
        
        public function logout()
        {
            Helper::logout();
        }
	}