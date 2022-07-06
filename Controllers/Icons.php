<?php 

	/**
	* 
	*/
	class Icons extends Controllers
	{
		
		public function __construct()
		{
			# code...
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
			}
			parent::__construct();
			
		}

		public function icons()
		{

			$data['page_tag']='ICONOS';
			$data['page_title']='SISTEMA DE FORMATOS - ICONOS';
			$data['page_name']='icnos';
			$data['page_function_js']='function_icnos.js';
			$this->views->getView($this,'icons',$data);
		}



	}

?>