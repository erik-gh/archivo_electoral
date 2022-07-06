<?php 

	/**
	* 
	*/
	class Dashboard extends Controllers
	{
		
		public function __construct()
		{
			# code...
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
				exit;
			}
			parent::__construct();
			
		}

		public function dashboard()
		{

			$data['page_tag']='SISCOMAC - Inicio';
			$data['page_title']='SISCOMAC - GGE';
			$data['page_name']='dashboard';
			$data['page_function_js']='function_dashboard.js';
			$data['request_password']= $_SESSION['resquest_pwd'];
			$this->views->getView($this,'dashboard',$data);
		}


		public function setUpdatePassword()
		{
			//dep($_POST); exit;
			if($_POST){

				if(empty($_POST['newpassword'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$strPassword	= hash_encript(strClean($_POST['newpassword']));
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$requestUsuario	= $this->model->updateUsuarioPass($intUserSession, $strPassword);

					if($requestUsuario > 0){
						$arrResponse = 	[
											"status"=> true,
											"title"	=> "Usuarios",
											"msg" 	=> "Contraseña Actualizados Correctamente.",
										];

					}else{

						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Error!",
										    "msg" 	=> "No se puede conectarse a la Base Datos",
										];
					}
				}

			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}



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



		public function getResumenProceso()
		{

			if($_POST) {
				
				$intIdProceso = ($_POST['idProceso'] != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$arrData = $this->model->selectResumenProceso($intIdProceso);

				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function getResumenOdpe()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				
				$output = array();
				$requestOdpe = $this->model->selectResumenOdpe($intIdProceso);

				for ($i=0; $i <  count($requestOdpe); $i++) {

					# code...
					$requestOdpe[$i]['ORDEN'] 	= 	$i+1;
					
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestOdpe
				);
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}

		
		public function selectResumenSoltec()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso = ($_POST['idProceso'] != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				
				$output = array();
				$requestSoltec = $this->model->selectResumenSoltec($intIdProceso);

				for ($i=0; $i <  count($requestSoltec); $i++) {

					# code...
					//$requestSoltec[$i]['ORDEN'] 	= 	$i+1;
					$requestSoltecChart[$i]['name'] = 	$requestSoltec[$i]['SOLUCIONTECNOLOGICA'];
					$requestSoltecChart[$i]['y'] 	= 	$requestSoltec[$i]['PORCENTAJE'];

					
				}

				if(empty($requestSoltec)){
					$requestSoltecChart[$i]['name'] = 	'- -';
					$requestSoltecChart[$i]['y'] 	= 	0;
				}
				
				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestSoltecChart
				);
			}

			echo json_encode($output,JSON_NUMERIC_CHECK);
			die();
		}


	}

?>