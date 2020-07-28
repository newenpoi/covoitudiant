<?php
	namespace Covoitudiant\Controller;
    
    use Covoitudiant\Lib\Controller;
	
	class ErrorController extends Controller
	{
		public function __construct()
		{
			$this->index();
		}
		
		public function index()
		{
			echo $this->render('error/404.php');
		}
	}