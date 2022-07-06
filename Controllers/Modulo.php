<?php 

	/**
	* 
	*/
	class Modulo extends Controllers
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


		public function modulo()
		{

			/*$data['page_tag']='MODULOS';
			$data['page_title']='SISTEMA DE FORMATOS - MODULOS';
			$data['page_name']='modulos';
			$data['page_function_js']='function_modulos.js';
			$this->views->getView($this,'modulo',$data);*/
		}


		public function getModulos()
		{
			
			$output = array();
			$arrData = $this->model->selectModulos();
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ICONO']	= 	'<span class="menu-icon"><i class="zmdi zmdi-'.$arrData[$i]['ICONO'].'" style="font-size:24px;"></i></span>';
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_modulo" class="btn btn-primary btn-xs" title="Editar" onclick="editarModulo('.$arrData[$i]['ID_MODULO'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>';
			}

			$output = array(
				//"draw"				=>	intval($_POST["draw"]),
				//"recordsTotal"		=> 	$arrData[2]['row'],
				//"recordsFiltered"	=>	$arrData[1]['row'],
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getModulo($idModulo)
		{

			$intIdModulo = intval(strClean($idModulo));

			if ($intIdModulo > 0) {
				
				$arrData = $this->model->selectModulo($intIdModulo);

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


		public function setModulo()
		{
			if($_POST){
				if(empty($_POST['modulo']) || empty($_POST['descripcion']) || empty($_POST['icono']) || empty($_POST['url'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdModulo	= intval(strClean($_POST['IdModulo']));
					$intControl		= intval(strClean($_POST['controlModulo']));
					$strModulo		= strClean($_POST['modulo']);
					$strDescripcion	= strClean($_POST['descripcion']);
					$strIcono		= strClean($_POST['icono']);
					$intEstado		= intval(strClean($_POST['estado']));
					
					$requestModulo	= $this->model->updateModulo($intIdModulo, $strModulo, $strDescripcion, $strIcono, $intEstado);
					

					if($requestModulo > 0){
						$arrResponse = 	[
											"status"=> true,
											"title"	=> "Módulos",
											"msg" 	=> "Datos Actualizados Correctamente.",
										];
						
					}else if($requestModulo == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se encuentra registrado este Módulo.",
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


		/* ASIGNAR */
		public function getSelectModulos()
		{
			$htmlOptions = '';
			$arrData = $this->model->selectCboModulos();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option data-icon="zmdi zmdi-'.$arrData[$i]['ICONO'].'" value="'.$arrData[$i]['ID_MODULO'].'"> '.$arrData[$i]['MODULO'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function setAsignar()
		{
			if($_POST){
				if(empty($_POST['modulos']) || empty($_POST['perfil'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intControl		= intval(strClean($_POST['controlAsignar']));
					$intIdPerfil	= intval(strClean($_POST['perfil']));
					$intidModulos	= $_POST['modulos'];
					
					$requestDelete = $this->model->deleteAsignar($intIdPerfil);
					foreach($intidModulos as $row){

						$requestAsignar	= $this->model->insertAsignar($intIdPerfil, $row);
					
					}

					if($requestAsignar > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Asignar Módulos",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Asignar Módulos",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
						
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


		public function getModulosAsignados()
		{
			
			$output = array();
			$arrData = $this->model->selectModulosAsignar(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	 = 	$i+1;
				$arrData[$i]['MODULOS'] = 	'<span style="text-decoration:underline;">'.$arrData[$i]['MODULOS'].'</span>,';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarAsignar('.$arrData[$i]['ID_PERFIL'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
												<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarAsignar('.$arrData[$i]['ID_PERFIL'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array("data" => $arrData);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function delAsignar($idPerfil)
		{
			
				$intIdPerfil 	= intval(strClean($idPerfil));
				$requestDelete  = $this->model->deleteAsignar($intIdPerfil);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Asignar Modulos",
										"msg" 	=> "Perfil Eliminado Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Perfil",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				die();
		}


		public function getAsignar($idPerfil)
		{

			$intIdPerfil = intval(strClean($idPerfil));

			if ($intIdPerfil > 0) {
				
				$arrData = $this->model->selectAsignar($intIdPerfil);

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

	}
?>