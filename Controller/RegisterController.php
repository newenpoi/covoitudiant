<?php
	namespace Covoitudiant\Controller;
	
	use Covoitudiant\Lib\Controller;
	use Covoitudiant\Lib\Helper;

	use Covoitudiant\Model\User;
	
	class RegisterController extends Controller
	{
		private $user = null;
		private $errors = array();

		public function __construct()
		{
			$this->user = new User();
            
			$action = Helper::get_action($this);
            
            $this->$action();
		}
		
		public function index()
		{
			echo $this->render('register/index.php');
		}
		
		public function create()
		{
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			$token = substr(md5(uniqid(rand(), true)), 16, 16);

			/*
				Renvoie vers l'index si aucune adresse email n'est spécifiée.
				Renvoie une erreur en cas de filtre invalide ou si l'utilisateur n'a pas été ajouté à la table.
			*/

			if ($email === null)
			{
				echo $this->render('register/index.php');
			}
			else
			{
				if ($email == false || $this->user->add($email, $token) == false)
					$this->errors[] = "Impossible d'enregistrer l'utilisateur.";

				echo ($this->errors ? $this->render('register/index.php', array('errors' => $this->errors)) : $this->render('register/success.php'));
			}
		}

		public function verify()
		{
			$parameters = Helper::get_param('parameters');

			$parameters = explode(':', $parameters);

			$email = $parameters[0];
			$token = $parameters[1];
			
			$formation = $this->user->verify($email, $token);
			
			/*
				Renvoie vers le formulaire de finalisation si l'adresse et le jeton ont été vérifiés et que la formation a bien été affectée.
			*/

			if ($formation)
				echo $this->render('register/complete.php', array('email' => $email, 'token' => $token));
			else
				echo $this->render('home/index.php');
		}

		public function complete()
		{
			$errors = array();

			/*
				L'email et le jeton sont dans ce cas ci sont liés au formulaire (en hidden).
			*/

			$email = filter_input(INPUT_POST, 'email');
			$token = filter_input(INPUT_POST, 'token');

			$id_formation = $this->user->verify($email, $token);

			if (!$id_formation)
			{
				echo $this->render('home/index.php');
			}
			else
			{
				$passwd = filter_input(INPUT_POST, 'passwd');
				$passwd_repeat = filter_input(INPUT_POST, 'passwd_repeat');
				$name = filter_input(INPUT_POST, 'name');
				$fname = filter_input(INPUT_POST, 'forename');
				$secret_question = filter_input(INPUT_POST, 'secret_question');
				$secret_answer = filter_input(INPUT_POST, 'secret_answer');

				// Vérifie que la géolocalisation existe et renvoi une clé en cas de succès.
				$loc = $this->user->verify_location(filter_input(INPUT_POST, 'location'));
				
				if (!Helper::passwd_verif($passwd))
				{
					$errors[] = "Ce mot de passe n'est pas acceptable.";
				}
				
				if ($passwd != $passwd_repeat)
				{
					$errors[] = "Les mots de passe ne sont pas identiques.";
				}
	
				if (!$name)
				{
					$errors[] = "Votre nom n'est pas valide.";
				}
	
				if (!$fname)
				{
					$errors[] = "Votre prénom n'est pas valide.";
				}
	
				if (!$loc)
				{
					$errors[] = "Ce lieu de départ n'est pas valide.";
				}
				
				if (strlen($secret_question) < 3 || strlen($secret_question) > 64)
				{
					$errors[] = "Votre question secrète personnalisée est trop courte ou trop longue.";
				}
				
				if (strlen($secret_answer) < 3 || strlen($secret_answer) > 255)
				{
					$errors[] = "La réponse à votre question secrète est trop courte ou trop longue.";
				}
	
				if (!$errors)
				{
					$response = $this->user->allow($email, $loc['ville_id'], $id_formation, $passwd, $name, $fname, $secret_question, $secret_answer);
	
					if (!$response)
					{
						echo $this->render('register/complete.php');
					}
					else
					{
						echo $this->render('register/done.php');
					}
				}
			}
		}
	}