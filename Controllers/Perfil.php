<?php 

	/**
	* 
	*/
	class Perfil extends Controllers
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


		public function perfil()
		{

			/*$data['page_tag']='PERFILES';
			$data['page_title']='SISTEMA DE FORMATOS - PERFILES';
			$data['page_name']='perfiles';
			$data['page_function_js']='function_perfil.js';
			$this->views->getView($this,'perfil',$data);*/
		}


		public function setPerfil()
		{	
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['perfil']) || empty($_POST['descripcion'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdPerfil	= intval(strClean($_POST['Idperfil']));
					$intControl		= intval(strClean($_POST['controlPerfil']));
					$strPerfil		= strClean($_POST['perfil']);
					$strDescripcion	= strClean($_POST['descripcion']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestPerfil	= $this->model->insertPerfil($strPerfil, $strDescripcion, $intUserSession);
					}else{
						$requestPerfil	= $this->model->updatePerfil($intIdPerfil, $strPerfil, $strDescripcion, $intUserSession, $intEstado);
					}

					if($requestPerfil > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Perfiles",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Perfiles",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
					}else if($requestPerfil == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se encuentra registrado este Perfil.",
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


		public function getPerfiles()
		{
			
			$output = array();
			$arrData = $this->model->selectPerfiles();

			//dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData[0]); $i++) { 
				# code...
				$arrData[0][$i]['orden'] 	= 	$i+1;
				$arrData[0][$i]['ESTADO'] 	= 	$arrData[0][$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[0][$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarPerfil('.$arrData[0][$i]['ID_PERFIL'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarPerfil('.$arrData[0][$i]['ID_PERFIL'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	$arrData[2]['FILA'],
				"recordsFiltered"	=>	$arrData[1]['FILA'],
				"data"				=>	$arrData[0]
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getPerfil($idPerfil)
		{

			$intIdPerfil = intval(strClean($idPerfil));

			if ($intIdPerfil > 0) {
				
				$arrData = $this->model->selectPerfil($intIdPerfil);

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


		public function delPerfil($idPerfil)
		{
			
				$intIdPerfil 	= intval(strClean($idPerfil));
				$requestDelete 	= $this->model->deletePerfil($intIdPerfil);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Perfiles",
										"msg" 	=> "Perfil Eliminado Correctamente.",
									];

				}else if($requestDelete == 'exist'){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Alerta!",
										"msg" 	=> "No se puede eliminar el Perfil, esta asociado a un Usuario.",
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


		public function getSelectPerfiles()
		{
			$htmlOptions = '<option value="">[ Seleccione Tipo Perfil ]</option>';
			$arrData = $this->model->selectCboPerfiles();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_PERFIL'].'"> '.$arrData[$i]['PERFIL'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}



		public function getSelectPerfilesModulo()
		{
			$htmlOptions = '<option value="">[ Seleccione Tipo Perfil ]</option>';
			$arrData = $this->model->selectCboPerfilesModulo();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_PERFIL'].'"> '.$arrData[$i]['PERFIL'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}
	}

?>