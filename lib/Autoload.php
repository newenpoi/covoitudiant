<?php
	/**
	*	Simple autoloader.
	*/
	
	namespace Covoitudiant\Lib;
	
	define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/../../");

	class Autoloader
	{
		public static function register()
		{
			spl_autoload_register(function ($class)
			{
				$name = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
				$file = ROOT . $name;
				
				if (file_exists($file))
				{
					require $file;
					return true;
				}
				
				return false;
			});
		}
	}
	
	Autoloader::register();