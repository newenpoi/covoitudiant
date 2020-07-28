<?php
	/*
		Covoitudiant
		Simple MVC (enfin on va essayer).
	*/

	define('CSS_PATH', 'http://localhost/covoitudiant/public/css/');
	define('IMG_PATH', 'http://localhost/covoitudiant/public/img/');
	define('AVA_PATH', 'http://localhost/covoitudiant/public/avatar/');
	define('SND_PATH', 'http://localhost/covoitudiant/public/snd/');
	define('JS_PATH',  'http://localhost/covoitudiant/public/js/');

    session_start();
	
	define('APP_START', microtime(true));
	
	require '../lib/Autoload.php';

	$controller = filter_input(INPUT_GET, 'controller');

	if (!$controller)
	{
		$controller = new \Covoitudiant\Controller\HomeController;
	}
	else
	{
		$controller = "\Covoitudiant\Controller\\" . ucfirst($controller . 'Controller');

		(class_exists($controller) ? new $controller : new \Covoitudiant\Controller\ErrorController);
	}