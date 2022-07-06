<?php 

	/**
	* 
	*/
	class Template extends Controllers
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

		public function template()
		{
			/*$data['page_tag']='Fichas';
			$data['page_title']='FICHAS';
			$data['page_name']='ficha';
			$data['page_function_js']='function_template.js';
			$this->views->getView($this,'template',$data);*/
		}

	}

?>