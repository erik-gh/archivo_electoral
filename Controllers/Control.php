<?php 

	/**
	* 
	*/
	class Control extends Controllers
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

		public function control()
		{
			$data['page_tag']='Control de Calidad';
			$data['page_title']='CONTROL DE CALIDAD';
			$data['page_name']='control';
			$data['page_function_js']='function_control.js';
			$this->views->getView($this,'control',$data);
		}


		/* ===== STEP 1 ===== */
		public function getSelectProceso()
		{

			$htmlOptions = '<option value="">[ SELECCIONE PROCESO ]</option>';
			$arrData = $this->model->selectCboProceso();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_PROCESO'].'" data="'.$arrData[$i]['ELECCION'].'"> '.$arrData[$i]['PROCESO']. ' ('.$arrData[$i]['DESCRIPCION']. ')</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getSelectPanel($id)
		{	

			$strPanel = strClean($id);
			$data['page_function_js']='function_control_'.$id.'.js';
			$this->views->getView($this,'control_'.$id, $data);

		}


	}

?>