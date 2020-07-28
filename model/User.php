<?php
	namespace Covoitudiant\Model;
	
	use Covoitudiant\Lib\Model;
	
	class User extends Model
	{
		/*
			Connexion
		*/
		
		public function login($email)
		{
            $this->query("SELECT id, passwd, role_id, first_name, loc FROM ct_users WHERE email = :email");
            
            $this->bind(':email', $email);
            
            return $this->single();
		}

		/*
			Ajoute un utilisateur via son adresse email.
		*/

		public function add($email, $token)
		{
			$this->query("INSERT INTO ct_pending (email, token) VALUES (:email, :token)");

			$this->bind(':email', $email);
			$this->bind(':token', $token);
			
			return $this->execute();
		}

		/*
			Vérifie l'intégrité du jeton et de l'adresse email avec pour valeur de retour l'id de formation.
		*/

		public function verify($email, $token)
		{
			$this->query("SELECT id_formation FROM ct_pending WHERE email = :email AND token = :token");

			$this->bind(':email', $email);
			$this->bind(':token', $token);

			return $this->single()['id_formation'];
		}

		public function verify_location($address)
		{
			$this->query("SELECT ville_id FROM ct_villes WHERE ville_nom_reel = :ville");

			$this->bind(':ville', $address);

			return $this->single();
		}

		public function allow($email, $loc, $formation, $passwd, $name, $fname, $secret_question, $secret_answer)
		{
			$this->query("INSERT INTO ct_users (email, loc, formation, passwd, first_name, last_name, secret_question, secret_answer) VALUES (:email, :loc, :formation, :passwd, :first_name, :last_name, :secret_question, :secret_answer)");

			$this->bind(':email', $email);
			$this->bind(':loc', $loc);
			$this->bind(':formation', $formation);
			$this->bind(':passwd', password_hash($passwd, PASSWORD_DEFAULT));
			$this->bind(':first_name', $fname);
			$this->bind(':last_name', $name);
			$this->bind(':secret_question', $secret_question);
			$this->bind(':secret_answer', $secret_answer);

			return $this->execute();
		}
	}