<?php 

	/**
	* 
	*/
	class Usuario extends Controllers
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


		public function usuario()
		{

			$data['page_tag']='Usuarios';
			$data['page_title']='PERFILES Y USUARIOS';
			$data['page_name']='usuarios';
			$data['page_function_js']='function_usuario.js';
			$this->views->getView($this,'usuario',$data);
		}


		public function setUsuario()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['dni']) || empty($_POST['apellido']) || empty($_POST['nombre']) || empty($_POST['perfil']) || empty($_POST['usuario'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdUsuario	= intval(strClean($_POST['IdUsuario']));
					$intControl		= intval(strClean($_POST['controlUsuario']));
					$strDNI			= strClean($_POST['dni']);
					$strApellido	= strClean($_POST['apellido']);
					$strNombre		= strClean($_POST['nombre']);
					$intPerfil		= intval(strClean($_POST['perfil']));
					$strUsuario		= strClean($_POST['dni']);
					$strPassword	= hash_encript(strClean($_POST['dni'])) ;
					$strUpdPassword	= (isset($_POST['password'])) ? hash_encript(strClean($_POST['password'])) : null ;
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestUsuario	= $this->model->insertUsuario($strDNI, $strApellido, $strNombre, $intPerfil, $strUsuario, $strPassword, $intUserSession);
					}else if($intControl == 1){
						$requestUsuario	= $this->model->updateUsuario($intIdUsuario, $strDNI, $strApellido, $strNombre, $intPerfil, $strUsuario, $intUserSession, $intEstado);
					}else{
						$requestUsuario	= $this->model->updateUsuarioPass($intIdUsuario, $strUpdPassword);
					}

					if($requestUsuario > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Usuarios",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else if($intControl == 1){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Usuarios",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Usuarios",
											    "msg" 	=> "Contraseña Actualizados Correctamente.",
											];
						}
					}else if($requestUsuario == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El DNI y/o Usuario ya se encuentra registrado.",
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


		public function getUsuarios()
		{
			
			$output = array();
			$arrData = $this->model->selectUsuarios(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarUsuario('.$arrData[$i]['ID_USUARIO'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarUsuario('.$arrData[$i]['ID_USUARIO'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getUsuario($idUsuario)
		{

			$intIdUsuario = intval(strClean($idUsuario));

			if ($intIdUsuario > 0) {
				
				$arrData = $this->model->selectUsuario($intIdUsuario);

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


		public function delUsuario($idUsuario)
		{
			
				$intIdUsuario 	= intval(strClean($idUsuario));
				$requestDelete 	= $this->model->deleteUsuario($intIdUsuario);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Usuarios",
										"msg" 	=> "Usuario Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Usuario",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function getSelectUsuarios()
		{
			$htmlOptions = '<option value="">[ Seleccione Usuario ]</option>';
			$arrData = $this->model->selectCboUsuarios();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['id_usuario'].'"> '.$arrData[$i]['apellido'].' '.$arrData[$i]['nombre'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}

	}

?>