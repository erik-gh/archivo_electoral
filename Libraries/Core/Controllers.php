<?php  

	/**
	* 
	*/
	class Controllers 
	{
		
		public function __construct()
		{
			# code...
			$this->views = new Views();
			$this->loadModel();
		}


		public function loadModel()
		{
			// homeModel.php
			$model = get_class($this).'Model';
			$routClass = 'Models/'.$model.'.php';

			if (file_exists($routClass)) {
				require_once($routClass);
				$this->model = new $model();
				# code...
			}
			//echo 'Mensaje desde el controlador';
		}

	}

?>