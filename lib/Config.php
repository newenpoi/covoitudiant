<?php
	namespace Covoitudiant\Lib;
	use Covoitudiant\Lib\CustomException;

	class Config
	{
		private static $parameters;

		public static function get($name, $default = null)
		{
			// Définie une valeur par défaut en cas d'absence du paramètre.
			$valeur = (isset(self::get_parameters()[$name]) ? self::get_parameters()[$name] : $default);
			
			return $valeur;
		}

		private static function get_parameters()
		{
			if (self::$parameters == null)
			{
				$path = "../config/prod.ini";
				
				// Si aucune production.
				if (!file_exists($path))
				{
					$path = "../config/dev.ini";
				}
				
				// Si malgré tout path n'existe pas.
				if (!file_exists($path))
				{
					// À revoir pour les exceptions.
					throw new CustomException("Aucun fichier de configuration n'a été trouvé, vérifiez l'installation.", 404);
				}
				else
				{
					self::$parameters = parse_ini_file($path);
				}
			}
			
			return self::$parameters;
		}
	}