<?php
	namespace Covoitudiant\Model;
	
	use Covoitudiant\Lib\Model;
	
	class Admin extends Model
	{
		/*
			Récupère le premier administrateur.
		*/
		public function any()
		{
			$this->query("SELECT COUNT(*) AS nb FROM ct_admin");
			
			return $this->single()['nb'];
		}
		
		/*
			Ajoute un utilisateur via son adresse email.
		*/
		public function add($email, $passwd, $secret_question, $secret_answer)
		{
			$this->query("INSERT INTO ct_admin (email, passwd, secret_question, secret_answer) VALUES (:email, :passwd, :secret_q, :secret_a)");
			
			$this->bind(':email', $email);
			$this->bind(':passwd', password_hash($passwd, PASSWORD_DEFAULT));
			$this->bind(':secret_q', $secret_question);
			$this->bind(':secret_a', $secret_answer);
			
			return $this->execute();
		}
        
        public function login($email)
        {
            $this->query("SELECT id, passwd FROM ct_admin WHERE email = :email");
            
            $this->bind(':email', $email);
            
            return $this->single();
		}
		
		public function recoverable($email, $secret_question, $secret_answer)
		{
			$this->query("SELECT email FROM ct_admin WHERE email = :email AND secret_question = :secret_q AND secret_answer = :secret_a");

			$this->bind(":email", $email);
			$this->bind("secret_q", $secret_question);
			$this->bind("secret_a", $secret_answer);

			return $this->single();
		}

		public function recover($email, $token)
		{
			$this->query('INSERT INTO ct_recover (email, token, expiration) VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 3600 SECOND))');

			$this->bind('email', $email);
			$this->bind('token', $token);

			return $this->execute();
		}

		public function verify($email, $token)
		{
			$this->query("SELECT id FROM ct_recover WHERE email = :email AND token = :token");

			$this->bind(':email', $email);
			$this->bind(':token', $token);

			return $this->single()['id'];
		}

		public function change_password($email, $password)
		{
			$this->query("UPDATE ct_admin SET passwd = :passwd WHERE id = :id");

			$this->bind(":passwd", $passwd);
			$this->bind(":id", $id);

			return $this->execute();
		}
	}