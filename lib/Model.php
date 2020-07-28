<?php
	namespace Covoitudiant\Lib;
	
	use PDO;
	
	require_once('Config.php');
	
	abstract class Model
	{
		private $pdo;
		private $statement;
		
		public function __construct()
		{
			if ($this->pdo === null)
			{
				$dsn = Config::get("dsn");
				$login = Config::get("login");
				$mdp = Config::get("password");
				
				$this->pdo = new PDO($dsn, $login, $mdp, 
					array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
				);
			}
		}

		/*
			Lier le/les paramètres.
		*/
		public function bind($param, $value, $type = null)
		{
			if (is_null($type))
			{
				switch (true)
				{
					case is_int($value):
						$type = PDO::PARAM_INT;
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
						break;
					default:
						$type = PDO::PARAM_STR;
				}
			}
			
			$this->statement->bindValue($param, $value, $type);
		}

		/*
			Prépare la requête.
		*/
		public function query($sql)
		{
			$this->statement = $this->pdo->prepare($sql);
		}
		
		/*
			Execute la requête.
		*/
		public function execute()
		{
			return $this->statement->execute();
		}
		
		/*
			Retourne un seul résultat.
		*/
		public function single()
		{
			$this->execute();
			return $this->statement->fetch(PDO::FETCH_ASSOC);
		}
		
		/*
			Retourne un jeu de résultat.
		*/
		public function resultSet()
		{
			$this->execute();
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		}
	}