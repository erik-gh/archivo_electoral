<?php 

	/**
	* 
	*/
	class Home extends Controllers
	{
		
		public function __construct()
		{
			# code...
			header('Location: login');
			parent::__construct();
		}

		public function home()
		{
			// $data['page_id']=1;
			$data['page_tag']='Home';
			$data['page_title']='Pagina Principal';
			$data['page_name']='home';
			$this->views->getView($this, 'home', $data);
		}

		/*public function datos($params)
		{
			echo 'Datos: '.$params;
		}

		public function carrito($params)
		{
			// echo 'Datos: '.$params;
			$carrito = $this->model->getCarrito($params);
			echo $carrito;
		}*/

	}

?>